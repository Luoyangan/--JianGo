<!DOCTYPE html>
<html lang="zh-CN">
<?php
require_once __DIR__. '/../../config/.version.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>502-简构 JianGo</title>
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
            .text-shadow {
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            .animate-float-delay {
                animation: float 6s ease-in-out 2s infinite;
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0px); }
            }
            /* 自定义logo动画 */
            .logo-animate {
                transition: transform 0.3s ease;
            }
            .logo-animate:hover {
                transform: rotate(5deg) scale(1.05);
            }
        }
    </style>
</head>
<body class="bg-tieba-gray min-h-screen flex flex-col opacity-0 transition-opacity duration-500">
    <!-- 背景装饰 -->
    <div class="fixed -top-20 -left-20 w-48 h-48 bg-tieba-blue/10 rounded-full blur-3xl"></div>
    <div class="fixed -bottom-32 -right-20 w-64 h-64 bg-tieba-blue/5 rounded-full blur-3xl"></div>
    
    <!-- 顶部导航栏 -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <!-- 新的logo设计 - 体现"简构"的简约构建理念 -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 logo-animate relative">
                    <!-- 几何图形组合，代表构建和结构 -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-8 h-8 border-2 border-tieba-blue rounded-sm flex items-center justify-center">
                            <div class="w-4 h-4 bg-tieba-blue/20 rounded-sm"></div>
                        </div>
                        <!-- 装饰线条，体现"构建"的概念 -->
                        <div class="absolute top-1/2 left-0 w-full h-0.5 bg-tieba-blue/30 -translate-y-1/2"></div>
                        <div class="absolute top-0 left-1/2 w-0.5 h-full bg-tieba-blue/30 -translate-x-1/2"></div>
                    </div>
                </div>
                <span class="text-xl font-bold text-gray-800">简构 JianGo</span>
            </div>
            <button class="md:hidden text-gray-600 hover:text-tieba-blue">
                <i class="fa fa-bars text-xl"></i>
            </button>
        </div>
    </header>

    <!-- 主体内容 -->
    <main class="flex-1 container mx-auto px-4 py-8 md:py-12 flex flex-col items-center justify-center">
        <!-- 加宽卡片宽度 -->
        <div class="max-w-2xl w-full bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg">
            <!-- 404提示区域 -->
            <div class="bg-tieba-light p-6 md:p-8 text-center border-b border-gray-100 relative overflow-hidden">
                <!-- 装饰图形 -->
                <div class="absolute top-4 right-4 flex gap-2">
                    <div class="w-6 h-6 bg-tieba-blue/20 rounded-full animate-float"></div>
                    <div class="w-4 h-4 bg-tieba-blue/30 rounded-full animate-float-delay"></div>
                </div>
                
                <div class="relative">
                    <div class="text-[100px] md:text-[150px] font-extrabold text-tieba-blue/10 mb-[-20px]">502</div>
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-tieba-blue text-white mb-4 animate-float">
                        <i class="fa fa-exclamation-triangle text-2xl"></i>
                    </div>
                </div>
                
                <h1 class="text-[clamp(1.8rem,5vw,2.5rem)] font-bold text-gray-800 mb-2 text-shadow">页面未找到</h1>
                <p class="text-tieba-dark text-base md:text-lg">此服务器上未找到所请求的页面或资源</p>
            </div>

            <!-- 操作和联系区域 -->
            <div class="p-6 md:p-8">
                <!-- 快捷操作按钮 -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
                    <a href="javascript:history.back()" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-tieba-blue text-tieba-blue rounded-lg hover:bg-tieba-light transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fa fa-arrow-left mr-2"></i>返回上一页
                    </a>
                    <a href="/" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-tieba-blue text-white rounded-lg hover:bg-tieba-blue/90 transition-all duration-300 transform hover:-translate-y-1 shadow hover:shadow-md">
                        <i class="fa fa-home mr-2"></i>返回首页
                    </a>
                </div>

                <!-- 联系信息卡片 - 垂直排列且靠左对齐 -->
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-100 card-hover">
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
    <footer class="bg-white border-t border-gray-200 mt-10 py-6">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 mb-4">
                <a href="#" class="hover:text-tieba-blue transition-colors">关于我们</a>
                <a href="#" class="hover:text-tieba-blue transition-colors">使用帮助</a>
                <a href="#" class="hover:text-tieba-blue transition-colors">用户协议</a>
                <a href="#" class="hover:text-tieba-blue transition-colors">隐私政策</a>
            </div>
            <p>
                <a href="https://mcyszl.top" target="_blank" class="hover:text-tieba-blue transition-colors">&copy; 2024-2025 原生之旅|mcyszl.top 版权所有</a>
			</p>
        </div>
    </footer>

    <!-- 交互脚本 -->
    <script>
        // 页面加载动画
        document.addEventListener('DOMContentLoaded', () => {
            // 添加页面载入动画
            document.body.classList.add('opacity-100');
            
            // 平滑滚动效果
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>