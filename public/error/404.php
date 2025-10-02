<!DOCTYPE html>
<html lang="zh-CN">
<?php
require_once __DIR__. '/../../config/.version.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404-模块框架</title>
<?PHP
require_once __DIR__. '/../../resource/.cssjs.php';
?>
    <!-- 配置Tailwind自定义颜色 -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tieba: {
                            blue: '#1677ff',    // 贴吧风格蓝色
                            light: '#e6f7ff',   // 浅蓝色背景
                            gray: '#f5f5f5',    // 浅灰色背景
                            dark: '#595959'     // 文字深灰色
                        }
                    },
                    fontFamily: {
                        sans: ['PingFang SC', 'Microsoft YaHei', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <!-- 自定义工具类 -->
    <style type="text/tailwindcss">
        @layer utilities {
            .content-auto {
                content-visibility: auto;
            }
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body class="bg-tieba-gray min-h-screen flex flex-col">
    <!-- 顶部导航栏 -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fa fa-comments text-tieba-blue text-2xl"></i>
                <span class="text-xl font-bold text-gray-800">贴吧框架</span>
            </div>
            <button class="md:hidden text-gray-600 hover:text-tieba-blue">
                <i class="fa fa-bars text-xl"></i>
            </button>
        </div>
    </header>

    <!-- 主体内容 -->
    <main class="flex-1 container mx-auto px-4 py-10 md:py-16">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <!-- 404提示区域 -->
            <div class="bg-tieba-light p-6 md:p-8 text-center border-b border-gray-100">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-tieba-blue text-white mb-6">
                    <i class="fa fa-exclamation-triangle text-2xl"></i>
                </div>
                <h1 class="text-[clamp(2rem,5vw,3rem)] font-bold text-gray-800 mb-3">404</h1>
                <p class="text-tieba-dark text-lg md:text-xl">此服务器上未找到所请求的页面或资源</p>
            </div>

            <!-- 操作和联系区域 -->
            <div class="p-6 md:p-8">
                <!-- 快捷操作按钮 -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-10">
                    <a href="javascript:history.back()" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-tieba-blue text-tieba-blue rounded-lg hover:bg-tieba-light transition-colors">
                        <i class="fa fa-arrow-left mr-2"></i>返回上一页
                    </a>
                    <a href="/" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-tieba-blue text-white rounded-lg hover:bg-tieba-blue/90 transition-colors">
                        <i class="fa fa-home mr-2"></i>返回首页
                    </a>
                </div>

                <!-- 联系信息卡片 -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fa fa-headphones text-tieba-blue mr-2"></i>需要帮助？联系我们
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <span class="w-24 text-gray-600"><i class="fa fa-qq text-gray-500 mr-2"></i>QQ：</span>
                            <span class="text-gray-800">1522676944</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-24 text-gray-600"><i class="fa fa-weixin text-gray-500 mr-2"></i>微信：</span>
                            <span class="text-gray-800">y13672984206</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-24 text-gray-600"><i class="fa fa-envelope text-gray-500 mr-2"></i>邮箱：</span>
                            <span class="text-gray-800">mcyszl@mcyszl.top</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- 页脚 -->
    <footer class="bg-white border-t border-gray-200 mt-12 py-6">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 mb-4">
                <a href="#" class="hover:text-tieba-blue transition-colors">关于我们</a>
                <a href="#" class="hover:text-tieba-blue transition-colors">使用帮助</a>
                <a href="#" class="hover:text-tieba-blue transition-colors">用户协议</a>
                <a href="#" class="hover:text-tieba-blue transition-colors">隐私政策</a>
            </div>
            <p><a href="https://mcyszl.top" target="_blank" class="hover:text-white transition-colors">&copy; 2024-2025 原生之旅|mcyszl.top 版权所有</a>
			</p>
        </div>
    </footer>

    <!-- 交互脚本 -->
    <script>
        // 页面加载动画
        document.addEventListener('DOMContentLoaded', () => {
            
            // 添加页面载入动画
            document.body.classList.add('opacity-100');
            document.body.classList.remove('opacity-0');
        });
    </script>
</body>
</html>