<?php
header('Content-Type: text/html; charset=UTF-8');

if (isset($_GET['file'])) {
    $targetFile = $_GET['file'] ?? '../index.php';
} else {
    $targetFile = '../index.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    $response = ['success' => false, 'message' => '保存失败'];
    
    if (isset($_POST['content']) && isset($_POST['filename'])) {

        $filename = $_POST['filename'];
        $saveFile = $filename;
        
        $content = $_POST['content'];
        if (isset($_POST['base64']) && $_POST['base64'] === 'true') {
            $content = base64_decode($content);
            if ($content === false) {
                die(json_encode(['success' => false, 'message' => 'Base64解码失败']));
            }
        }
        
        if (file_put_contents($saveFile, $content) !== false) {
            $response = [
                'success' => true,
                'message' => '保存成功',
                'time' => date('H:i:s')
            ];
        } else {
            $response['message'] = '无法写入文件，请检查权限或路径是否正确';
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$languageMappings = [
    'php' => 'php',
    'html' => 'html',
    'css' => 'css',
    'js' => 'javascript',
    'txt' => 'plaintext',
    'json' => 'json',
    'xml' => 'xml'
];

require_once __DIR__. '/../../module/pack/.getLanguageByExtension.php';
require_once __DIR__. '/../../module/pack/.getSourceCode.php';
require_once __DIR__. '/../../module/pack/.getSampleCodeByExtension.php';

// 编码后的代码
$encodedCode = getSourceCode($targetFile);
// 当前编辑的文件名
$currentFileName = basename($targetFile);
// 目标文件路径
$relativeFilePath = $targetFile;
// 自动检测语言
$detectedLanguage = getLanguageByExtension($targetFile, $languageMappings);
?>
<!DOCTYPE html>
<?php
require_once __DIR__. '/../../module/print/.model_log.php';
require_once __DIR__. '/../../module/pack/.title.php';
require_once __DIR__. '/../../module/pack/html/.coding.php';
require_once __DIR__. '/../../module/pack/html/.lang.php';
require_once __DIR__. '/../../config/.version.php';

lang('zh-CN');
?>
<head>
<?php
charset('UTF-8');
title(htmlspecialchars($currentFileName)." - 编辑器");
require_once __DIR__. '/../../seo/favicon/.icon.php';
?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
require_once __DIR__. '/../../resource/.cssjs.php';
?>
    <script src="/assets/js/vs.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0f172a',
                        secondary: '#1e293b',
                        accent: '#4F5D95',
                    },
                }
            }
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer utilities {
            .editor-container { height: calc(100vh - 4rem); }
            .toolbar-btn { @apply px-3 py-2 rounded hover:bg-gray-700 transition-colors; }
            .toolbar-btn:active { @apply bg-gray-700; }
            .language-indicator { @apply px-3 py-2 rounded bg-gray-800 text-sm; }
            .status-indicator { @apply px-3 py-2 text-sm; }
            .notification { 
                @apply fixed bottom-4 right-4 px-4 py-3 rounded shadow-lg transform transition-all duration-300 opacity-0 translate-y-4;
            }
            .notification.show { @apply opacity-100 translate-y-0; }
            .notification.success { @apply bg-green-600 text-white; }
            .notification.error { @apply bg-red-600 text-white; }
            .notification.info { @apply bg-blue-600 text-white; }
        }

        body {
            overflow: hidden;
            height: 100vh;
        }
    </style>
</head>
<body class="bg-primary text-gray-100">
    <!-- 通知组件 -->
    <div id="notification" class="notification"></div>
    
    <header class="bg-secondary py-4 px-6 border-b border-gray-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fa fa-code text-accent text-2xl"></i>
                <h1 class="text-xl font-bold">
                    <?php echo htmlspecialchars($currentFileName); ?>
                </h1>
            </div>
            
            <div class="flex items-center space-x-2">
                <!-- 保存状态指示器 -->
                <div id="saveStatus" class="status-indicator">
                    <i class="fa fa-clock-o mr-1"></i>
                    <span>未更改</span>
                </div>
                
                <div class="language-indicator">
                    <i class="fa fa-tag mr-1"></i>
                    <?php
                    $languageNames = [
                        'php' => 'PHP',
                        'html' => 'HTML',
                        'css' => 'CSS',
                        'javascript' => 'JavaScript',
                        'plaintext' => '纯文本',
                        'json' => 'JSON',
                        'xml' => 'XML'
                    ];
                    echo $languageNames[$detectedLanguage] ?? $detectedLanguage;
                    ?>
                </div>
                
                <div class="flex space-x-1">
                    <button id="saveBtn" class="toolbar-btn text-blue-400">
                        <i class="fa fa-save mr-1"></i> 保存
                    </button>
                    <button id="downloadBtn" class="toolbar-btn text-green-400">
                        <i class="fa fa-download mr-1"></i> 下载
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <div class="editor-container">
        <div id="editor" class="w-full h-full"></div>
    </div>

    <script>
        // Base64解码函数
        function base64Decode(encoded) {
            try {
                const decodedBytes = atob(encoded);
                const uint8Array = new Uint8Array(decodedBytes.length);
                for (let i = 0; i < decodedBytes.length; i++) {
                    uint8Array[i] = decodedBytes.charCodeAt(i);
                }
                const decoder = new TextDecoder('utf-8');
                return decoder.decode(uint8Array);
            } catch (e) {
                console.error('Base64解码失败:', e);
                showNotification('加载文件失败: 编码错误', 'error');
                return '';
            }
        }
        
        function showNotification(message, type = 'info') {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            setTimeout(() => notification.classList.add('show'), 10);
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
        
        function updateSaveStatus(status, time = '') {
            const statusEl = document.getElementById('saveStatus');
            const iconEl = statusEl.querySelector('i');
            const textEl = statusEl.querySelector('span');
            
            switch(status) {
                case 'saved':
                    iconEl.className = 'fa fa-check mr-1 text-green-400';
                    textEl.textContent = `已保存 ${time ? '(' + time + ')' : ''}`;
                    break;
                case 'saving':
                    iconEl.className = 'fa fa-spinner fa-spin mr-1';
                    textEl.textContent = '保存中...';
                    break;
                case 'unsaved':
                    iconEl.className = 'fa fa-exclamation-triangle mr-1 text-yellow-400';
                    textEl.textContent = '未保存';
                    break;
                default:
                    iconEl.className = 'fa fa-clock-o mr-1';
                    textEl.textContent = '未更改';
            }
        }

        const encodedCode = "<?php echo $encodedCode; ?>";
        const currentFileName = "<?php echo htmlspecialchars($currentFileName); ?>";
        const detectedLanguage = "<?php echo $detectedLanguage; ?>";
        const targetFile = "<?php echo htmlspecialchars($relativeFilePath); ?>";
        const codeContent = base64Decode(encodedCode);
        let editor;
        let hasUnsavedChanges = false;
        let autoSaveTimer = null;

        require.config({ paths: { 'vs': 'https://cdn.jsdelivr.net/npm/monaco-editor@0.44.0/min/vs' }});
        require(['vs/editor/editor.main'], function() {
            editor = monaco.editor.create(document.getElementById('editor'), {
                value: codeContent,
                language: detectedLanguage,
                theme: 'vs-dark',
                fontSize: 14,
                minimap: { enabled: true },
                automaticLayout: true
            });
            
            editor.onDidChangeModelContent(() => {
                hasUnsavedChanges = true;
                updateSaveStatus('unsaved');
                
                // 自动保存（60秒无操作后自动保存）
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(() => {
                    if (hasUnsavedChanges) {
                        saveToServer();
                    }
                }, 60000);
            });
        });
        
        function saveToServer() {
            if (!editor) return;
            
            updateSaveStatus('saving');
            
            const code = editor.getValue();

            const formData = new FormData();
            formData.append('action', 'save');
            formData.append('filename', targetFile);
            formData.append('content', code);
            formData.append('base64', 'false');
            
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('网络响应不正常');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    hasUnsavedChanges = false;
                    updateSaveStatus('saved', data.time);
                    showNotification('文件已保存', 'success');
                } else {
                    updateSaveStatus('unsaved');
                    showNotification('保存失败: ' + data.message, 'error');
                }
            })
            .catch(error => {
                updateSaveStatus('unsaved');
                showNotification('保存时发生错误', 'error');
                console.error('保存错误:', error);
            });
        }

        function downloadFile() {
            if (!editor) return;
            
            const code = editor.getValue();
            const blob = new Blob([code], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = currentFileName;
            a.click();
            URL.revokeObjectURL(url);
            
            showNotification(`文件已下载: ${currentFileName}`, 'success');
        }
        
        document.getElementById('saveBtn').addEventListener('click', saveToServer);
        document.getElementById('downloadBtn').addEventListener('click', downloadFile);

        window.addEventListener('beforeunload', (e) => {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = '您有未保存的更改，确定要离开吗？';
                return e.returnValue;
            }
        });
    </script>
</body>
</html>