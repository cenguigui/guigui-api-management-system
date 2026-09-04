<?php
// 引入统计
// include_once('./api_stats.php');
include("./includes/api_stats.php");

$alias = isset($_REQUEST['alias']) ? $_REQUEST['alias'] : '';
$alias = trim(strip_tags(daddslashes($alias)));
?>
<!DOCTYPE html>
<html lang="zh-CN" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API 调用统计</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= $system['ico'] ?>">
    <!--<link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/bootstrap/5.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">-->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <!--<link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.9.10/css/layui.css" rel="stylesheet">-->
    <link href="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.11.5/css/layui.css" rel="stylesheet">
    <!--<script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>-->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <!--<script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.9.10/layui.js"></script>-->
    <script src="https://mirrors.sustech.edu.cn/cdnjs/ajax/libs/layui/2.11.5/layui.js"></script>
    <style>
        /* CDNJS 镜像服务 - 主样式文件 */
        :root {
            --primary: #ffacc7;
            /* 更柔和的粉色主色调 */
            --primary-dark: #ff8aac;
            --primary-light: #fff5f8;
            --secondary: #fffafb;
            /* 更淡的粉色背景 */
            --accent: #ffc2d6;
            /* 柔和的粉色强调色 */
            --success: #b8e6b8;
            /* 柔和的淡绿色 */
            --info: #c5e8f7;
            /* 柔和的淡蓝色 */
            --warning: #ffe0b8;
            /* 柔和的淡橙色 */
            --danger: #ffb8c2;
            /* 柔和的淡红色 */
            --light: #ffffff;
            /* 纯白背景 */
            --bg-gray: #fffafb;
            /* 淡粉色灰色背景 */
            --surface: #ffffff;
            /* 表面颜色 */
            --border-light: #ffeef2;
            /* 边框颜色 */
            --text-primary: #6a4b5a;
            /* 主要文字 - 更柔和的深粉色 */
            --text-secondary: #b298a3;
            /* 次要文字 - 更柔和的浅粉色 */
            --dark: #6a4b5a;
            /* 深色 - 更柔和的深粉色 */
            --text-disabled: #e0d1d8;
            /* 禁用文字 */
            --border: #ffdde6;
            /* 边框色 */
            --border-light: #fff2f5;
            /* 浅边框 */
            --shadow: 0 4px 12px rgba(255, 172, 199, 0.18);
            /* 粉色轻微阴影 */
            --shadow-hover: 0 8px 24px rgba(255, 172, 199, 0.25);
            /* 粉色悬停阴影 */
            --shadow-card: 0 4px 12px rgba(255, 172, 199, 0.15), 0 2px 6px rgba(255, 172, 199, 0.1);
            /* 粉色卡片阴影 */
            --transition: all 0.3s cubic-bezier(0.34, 0.69, 0.1, 1);
            /* 卡通风格过渡 */
            --radius: 16px;
            --accent1: #FFD6BA;
            --accent2: #B5E5CF;
            --accent3: #FFF1E6;
            --text-dark: #6a4b5a;
            --text-light: #b298a3;
        }

        body {
            background: linear-gradient(135deg, #fffafb 0%, #fff5f8 50%, #fffafb 100%);
            font-family: 'Comic Sans MS', 'Bubblegum Sans', cursive, sans-serif;
            color: var(--text-primary);
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(255, 172, 199, 0.1) 0px, transparent 80px),
                radial-gradient(circle at 80% 30%, rgba(255, 138, 172, 0.08) 0px, transparent 60px),
                radial-gradient(circle at 40% 70%, rgba(255, 194, 214, 0.12) 0px, transparent 100px);
            pointer-events: none;
            z-index: 0;
        }

        body > * {
            position: relative;
            z-index: 1;
        }

        /* 滚动条美化 */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--border-light);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        .layui-layer-molv .layui-layer-title {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        }

        /* 卡片样式 */
        .card {
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 24px;
            border: none;
            background-color: var(--light);
            transition: var(--transition);
            overflow: hidden;
        }

        [data-theme="dark"] .card {
            background-color: var(--surface);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: var(--radius) var(--radius) 0 0 !important;
            font-weight: 600;
            padding: 16px 20px;
            position: relative;
            overflow: hidden;
        }

        /* 卡片头部装饰 */
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0 0 0 100%;
        }

        .card-body {
            padding: 24px;
        }

        /* 统计卡片 */
        .stat-card {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--light) 100%);
            border-left: 5px solid var(--primary);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 60px;
            background: rgba(255, 172, 199, 0.05);
            border-radius: 0 0 0 100%;
        }

        .stat-card:hover {
            transform: scale(1.03);
            border-left-color: var(--primary-dark);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
            transition: var(--transition);
        }

        .stat-card:hover .stat-value {
            transform: translateX(5px);
        }

        .stat-label {
            font-size: 15px;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            font-size: 24px;
            color: var(--primary);
            margin-bottom: 10px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* 表格样式 */
        .table-responsive {
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            background-color: var(--light);
        }

        [data-theme="dark"] .table-responsive {
            background-color: var(--surface);
        }

        .table {
            background-color: transparent;
            margin-bottom: 0;
        }

        [data-theme="dark"] .table {
            background-color: transparent;
        }

        .table tbody {
            background-color: var(--light);
        }

        [data-theme="dark"] .table tbody {
            background-color: var(--surface);
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 12px 15px;
            position: relative;
        }

        [data-theme="dark"] .table thead th {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .table thead th::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        [data-theme="dark"] .table thead th::after {
            background: rgba(255, 255, 255, 0.15);
        }

        .table thead th:hover::after {
            transform: scaleX(1);
        }

        .table tbody tr {
            transition: var(--transition);
            background-color: var(--light);
        }

        [data-theme="dark"] .table tbody tr {
            background-color: var(--surface);
        }

        .table tbody tr:hover {
            background-color: var(--primary-light);
            transform: translateX(5px);
        }

        [data-theme="dark"] .table tbody tr:hover {
            background-color: var(--border);
        }

        .table tbody td {
            padding: 12px 15px;
            border-color: var(--border-light);
            color: var(--text-primary);
            background-color: inherit;
        }

        [data-theme="dark"] .table tbody td {
            color: var(--text-primary);
            background-color: inherit;
        }

        /* 确保表格内所有文字在夜间模式下都是白色 */
        [data-theme="dark"] .table tbody {
            color: var(--text-primary);
        }

        [data-theme="dark"] .table tbody * {
            color: var(--text-primary);
        }

        /* 可点击的API名称样式 */
        .api-name-link {
            color: var(--primary-dark);
            font-weight: 600;
            cursor: pointer;
            position: relative;
            text-decoration: none;
            padding-bottom: 2px;
        }

        [data-theme="dark"] .api-name-link {
            color: var(--primary);
        }

        .api-name-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        .api-name-link:hover {
            color: var(--primary);
        }

        .api-name-link:hover::after {
            width: 100%;
        }

        /* 排名颜色样式 */
        .rank-1 {
            color: #ffd700;
        }

        .rank-2 {
            color: #c0c0c0;
        }

        .rank-3 {
            color: #cd7f32;
        }

        [data-theme="dark"] .rank-1 {
            color: #ffd700;
        }

        [data-theme="dark"] .rank-2 {
            color: #c0c0c0;
        }

        [data-theme="dark"] .rank-3 {
            color: #ff8aac;
        }

        /* 图表容器 */
        .chart-container {
            position: relative;
            height: 350px;
            margin-bottom: 24px;
            border-radius: var(--radius);
            background-color: var(--light);
            padding: 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        [data-theme="dark"] .chart-container {
            background-color: var(--surface);
        }

        .chart-container:hover {
            box-shadow: var(--shadow-hover);
        }

        /* 导航标签 */
        .nav-tabs {
            border-bottom: 2px solid var(--border);
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            color: var(--text-light);
            border: none;
            border-radius: 0;
            padding: 10px 20px;
            margin-right: 5px;
            position: relative;
            transition: var(--transition);
        }

        .nav-tabs .nav-link.active {
            font-weight: 600;
            color: var(--primary-dark);
            background-color: transparent;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary);
        }

        .nav-tabs .nav-link:hover:not(.active) {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        /* 参考线样式 */
        .reference-line {
            border-top: 1px dashed rgba(255, 172, 199, 0.5);
            position: absolute;
            width: calc(100% - 40px);
            z-index: 1;
        }

        .reference-label {
            position: absolute;
            right: 30px;
            background: var(--light);
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
            color: var(--text-primary);
            box-shadow: var(--shadow);
        }

        [data-theme="dark"] .reference-label {
            background: var(--surface);
        }

        /* 夜间模式配色 */
        [data-theme="dark"] {
            --primary: #ffacc7;
            /* 粉色主色调 */
            --primary-dark: #ff8aac;
            --primary-light: #2a1f25;
            --secondary: #1a1416;
            /* 夜间深色背景 */
            --accent: #ffc2d6;
            /* 粉色强调色 */
            --success: #88d4b5;
            --info: #95d8f7;
            --warning: #ffd8a8;
            --danger: #ffb8c2;
            --light: #1a1416;
            /* 夜间深色背景 */
            --bg-gray: #1a1416;
            /* 夜间灰色背景 */
            --surface: #2a1f25;
            /* 夜间表面颜色 */
            --border-light: #3a2d35;
            /* 夜间边框颜色 */
            --text-primary: #ffffff;
            /* 夜间主要文字 */
            --text-secondary: #d9c2c9;
            /* 夜间次要文字 */
            --dark: #ffffff;
            /* 夜间深色文字 */
            --text-disabled: #8a7a82;
            /* 夜间禁用文字 */
            --border: #4a3d45;
            /* 夜间边框色 */
            --border-light: #3a2d35;
            /* 夜间浅边框 */
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            /* 夜间轻微阴影 */
            --shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.5);
            /* 夜间悬停阴影 */
            --shadow-card: 0 4px 12px rgba(0, 0, 0, 0.35), 0 2px 6px rgba(0, 0, 0, 0.3);
            /* 夜间卡片阴影 */
            --text-dark: #ffffff;
            --text-light: #d9c2c9;
        }

        /* 夜间模式下的卡通装饰 */
        [data-theme="dark"] .cartoon-cloud,
        [data-theme="dark"] .cartoon-star,
        [data-theme="dark"] .cartoon-heart,
        [data-theme="dark"] .cartoon-sparkle {
            opacity: 0.15;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.5));
        }

        [data-theme="dark"] .cartoon-cloud {
            color: #6a4b5a;
        }

        [data-theme="dark"] .cartoon-star {
            color: #8a7a82;
        }

        [data-theme="dark"] .cartoon-heart {
            color: #ff8aac;
        }

        [data-theme="dark"] .cartoon-sparkle {
            color: #6a7a8a;
        }

        /* 页面标题样式 */
        .page-title {
            color: var(--primary-dark);
        }

        [data-theme="dark"] .page-title {
            color: var(--text-primary);
        }

        /* Bootstrap text-muted 类在夜间模式下的样式 */
        [data-theme="dark"] .text-muted {
            color: var(--text-secondary) !important;
        }

        [data-theme="dark"] body {
            background: linear-gradient(135deg, #1a1416 0%, #2a1f25 50%, #1a1416 100%);
        }

        [data-theme="dark"] body::before {
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(255, 172, 199, 0.08) 0px, transparent 80px),
                radial-gradient(circle at 80% 30%, rgba(255, 138, 172, 0.06) 0px, transparent 60px),
                radial-gradient(circle at 40% 70%, rgba(255, 194, 214, 0.1) 0px, transparent 100px);
        }

        /* 昼夜切换按钮 */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 24px;
            cursor: pointer;
            box-shadow: var(--shadow-hover);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: var(--shadow-hover);
        }

        .theme-toggle:active {
            transform: scale(0.95);
        }

        [data-theme="dark"] .theme-toggle {
            background: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(255, 138, 172, 0.3);
        }

        [data-theme="dark"] .theme-toggle:hover {
            background: var(--primary);
            box-shadow: 0 8px 24px rgba(255, 138, 172, 0.4);
        }

        /* 卡通风格背景装饰 */
        .cartoon-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 999;
            overflow: hidden;
        }

        .cartoon-cloud,
        .cartoon-star,
        .cartoon-heart,
        .cartoon-sparkle {
            position: absolute;
            font-size: 2.5rem;
            opacity: 0.4;
            animation: floatAnimation 8s ease-in-out infinite;
            filter: drop-shadow(2px 2px 4px rgba(255, 172, 199, 0.4));
            z-index: 1;
        }

        .cartoon-cloud {
            color: #ffffff;
            text-shadow: 3px 3px 6px rgba(255, 194, 214, 0.6);
            font-size: 3rem;
        }

        .cartoon-star {
            color: #fffacd;
            animation-delay: 1s;
            text-shadow: 0 0 15px rgba(255, 215, 0, 0.7);
        }

        .cartoon-heart {
            color: #ffacc7;
            animation-delay: 2s;
            text-shadow: 0 0 12px rgba(255, 172, 199, 0.6);
        }

        .cartoon-sparkle {
            color: #b8e6ff;
            animation-delay: 3s;
            font-size: 2rem;
            text-shadow: 0 0 10px rgba(184, 230, 255, 0.6);
        }

        /* 装饰元素位置和动画 */
        .cloud-1 {
            top: 15%;
            left: 5%;
            animation-duration: 12s;
        }

        .cloud-2 {
            top: 55%;
            right: 8%;
            animation-duration: 15s;
            animation-delay: 3s;
        }

        .cloud-3 {
            top: 25%;
            right: 20%;
            animation-duration: 18s;
            animation-delay: 6s;
        }

        .star-1 {
            top: 10%;
            right: 12%;
            animation-duration: 8s;
        }

        .star-2 {
            top: 65%;
            left: 12%;
            animation-duration: 10s;
            animation-delay: 2s;
        }

        .star-3 {
            top: 35%;
            left: 25%;
            animation-duration: 14s;
            animation-delay: 4s;
        }

        .heart-1 {
            top: 20%;
            left: 35%;
            animation-duration: 9s;
        }

        .heart-2 {
            top: 60%;
            right: 30%;
            animation-duration: 11s;
            animation-delay: 5s;
        }

        .sparkle-1 {
            top: 45%;
            left: 15%;
            animation-duration: 7s;
        }

        .sparkle-2 {
            top: 30%;
            right: 40%;
            animation-duration: 9s;
            animation-delay: 2s;
        }

        .sparkle-3 {
            top: 70%;
            right: 15%;
            animation-duration: 11s;
            animation-delay: 4s;
        }

        @keyframes floatAnimation {
            0%, 100% {
                transform: translateY(0) translateX(0) scale(1) rotate(0deg);
                opacity: 0.3;
            }
            25% {
                transform: translateY(-25px) translateX(15px) scale(1.15) rotate(8deg);
                opacity: 0.6;
            }
            50% {
                transform: translateY(-12px) translateX(-8px) scale(1.08) rotate(-5deg);
                opacity: 0.5;
            }
            75% {
                transform: translateY(15px) translateX(8px) scale(0.92) rotate(4deg);
                opacity: 0.35;
            }
        }

        /* 添加脉动动画效果 */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.4;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
        }

        .cartoon-heart {
            animation: floatAnimation 9s ease-in-out infinite, pulse 3s ease-in-out infinite;
        }

        .cartoon-star {
            animation: floatAnimation 10s ease-in-out infinite, pulse 4s ease-in-out infinite 1s;
        }

        /* 动画效果 */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        /* 响应式调整 */
        @media (max-width: 768px) {
            .stat-value {
                font-size: 24px;
            }

            .chart-container {
                height: 300px;
            }

            .card-header h5 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <!-- 卡通风格背景装饰 -->
    <div class="cartoon-background">
        <div class="cartoon-cloud cloud-1">☁️</div>
        <div class="cartoon-cloud cloud-2">☁️</div>
        <div class="cartoon-cloud cloud-3">☁️</div>
        <div class="cartoon-star star-1">✨</div>
        <div class="cartoon-star star-2">✨</div>
        <div class="cartoon-star star-3">✨</div>
        <div class="cartoon-heart heart-1">💖</div>
        <div class="cartoon-heart heart-2">💖</div>
        <div class="cartoon-sparkle sparkle-1">🌟</div>
        <div class="cartoon-sparkle sparkle-2">🌟</div>
        <div class="cartoon-sparkle sparkle-3">🌟</div>
    </div>

    <!-- 昼夜切换按钮 -->
    <button class="theme-toggle" id="themeToggle" title="切换主题">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <div class="container-fluid py-5 px-3 px-md-5">
        <!-- 页面标题 -->
        <div class="row mb-5 animate-fade-in">
            <div class="col-12 text-center">
                <h2 class="page-title">
                    <i class="fas fa-chart-line me-3" style="animation: float 3s ease-in-out infinite;"></i>
                    API 调用统计中心
                </h2>
                <p class="text-muted mt-2">实时监控您的API调用情况与趋势分析</p>
            </div>
        </div>

        <?php if ($alias && $api_stats = getApiStatsByAlias($alias)): ?>
            <div class="row mb-5 animate-fade-in delay-100">
                <!-- 特定API统计 -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold">
                                <i class="fas fa-chart-pie me-2"></i>
                                API调用统计 - <?php echo htmlspecialchars($api_stats['name']); ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card stat-card h-100 py-4">
                                        <div class="card-body text-center">
                                            <div class="stat-icon">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <div class="stat-label">别名</div>
                                            <div class="stat-value" style="font-size: 22px;"><?php echo htmlspecialchars($api_stats['name']); ?>(<?php echo htmlspecialchars($api_stats['alias']); ?>)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card stat-card h-100 py-4">
                                        <div class="card-body text-center">
                                            <div class="stat-icon">
                                                <i class="fas fa-sun"></i>
                                            </div>
                                            <div class="stat-label">今日调用次数</div>
                                            <div class="stat-value"><?php echo number_format($api_stats['today_calls']); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card stat-card h-100 py-4">
                                        <div class="card-body text-center">
                                            <div class="stat-icon">
                                                <i class="fas fa-globe"></i>
                                            </div>
                                            <div class="stat-label">总调用次数</div>
                                            <div class="stat-value"><?php echo number_format($api_stats['total_calls']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- 全局统计 -->
        <div class="row animate-fade-in delay-200">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold">
                            <i class="fas fa-globe-americas me-2"></i>
                            全局统计
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card stat-card h-100 py-4">
                                    <div class="card-body text-center">
                                        <div class="stat-icon">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                        <div class="stat-label">今日总调用次数</div>
                                        <div class="stat-value"><?php echo number_format(getTodayTotalCalls()); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card stat-card h-100 py-4">
                                    <div class="card-body text-center">
                                        <div class="stat-icon">
                                            <i class="fas fa-history"></i>
                                        </div>
                                        <div class="stat-label">历史总调用次数</div>
                                        <div class="stat-value"><?php echo number_format(getAllTimeTotalCalls()); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card mb-4 animate-fade-in delay-300">
                                    <div class="card-header py-3">
                                        <h5 class="m-0 font-weight-bold">
                                            <i class="fas fa-star me-2"></i>
                                            最受欢迎API Top 10
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-container" id="topApisChartContainer">
                                            <canvas id="topApisChart"></canvas>
                                            <div id="topApisReferenceLines"></div>
                                        </div>
                                        <div class="table-responsive animate-fade-in delay-400">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th><i class="fas fa-medal me-1" style="color: gold;"></i>排名</th>
                                                        <th><i class="fas fa-signature me-1"></i>API名称</th>
                                                        <th><i class="fas fa-tag me-1"></i>别名</th>
                                                        <th><i class="fas fa-counter me-1"></i>调用次数</th>
                                                        <th><i class="fas fa-percentage me-1"></i>占比</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $top_apis = getApiCallRanking(10);
                                                    $rank = 1;
                                                    foreach ($top_apis as $api): ?>
                                                        <tr>
                                                            <td>
                                                                <?php if ($rank == 1): ?>
                                                                    <span class="rank-1"><i class="fas fa-crown me-1"></i><?php echo $rank; ?></span>
                                                                <?php elseif ($rank == 2): ?>
                                                                    <span class="rank-2"><i class="fas fa-medal me-1"></i><?php echo $rank; ?></span>
                                                                <?php elseif ($rank == 3): ?>
                                                                    <span class="rank-3"><i class="fas fa-award me-1"></i><?php echo $rank; ?></span>
                                                                <?php else: ?>
                                                                    <?php echo $rank; ?>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <span class="api-name-link" onclick="openApiDetail('<?php echo htmlspecialchars($api['name']); ?>', '<?php echo htmlspecialchars($api['alias']); ?>')">
                                                                    <?php echo htmlspecialchars($api['name']); ?>
                                                                    <i class="fas fa-external-link-alt ms-1" style="font-size: 12px;"></i>
                                                                </span>
                                                            </td>
                                                            <td><?php echo htmlspecialchars($api['alias']); ?></td>
                                                            <td><?php echo number_format($api['views']); ?></td>
                                                            <td><?php echo number_format($api['views'] / max(1, getAllTimeTotalCalls()) * 100, 2); ?>%</td>
                                                        </tr>
                                                    <?php
                                                        $rank++;
                                                    endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 昼夜切换功能
        (function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const html = document.documentElement;
            
            // 从 localStorage 读取主题设置，如果没有则根据系统偏好设置
            function getInitialTheme() {
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    return savedTheme;
                }
                // 检查系统偏好
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    return 'dark';
                }
                return 'light';
            }
            
            // 设置主题
            function setTheme(theme) {
                if (theme === 'dark') {
                    html.setAttribute('data-theme', 'dark');
                    themeIcon.className = 'fas fa-sun';
                    localStorage.setItem('theme', 'dark');
                } else {
                    html.setAttribute('data-theme', 'light');
                    themeIcon.className = 'fas fa-moon';
                    localStorage.setItem('theme', 'light');
                }
            }
            
            // 初始化主题
            const initialTheme = getInitialTheme();
            setTheme(initialTheme);
            
            // 切换主题
            themeToggle.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
                
                // 更新图表工具提示背景色和文字颜色
                if (typeof window.topApisChart !== 'undefined' && window.topApisChart) {
                    window.topApisChart.options.plugins.tooltip.backgroundColor = getTooltipBackground();
                    window.topApisChart.options.plugins.tooltip.titleColor = getChartTextColor();
                    window.topApisChart.options.plugins.tooltip.bodyColor = getChartTextColor();
                    window.topApisChart.options.plugins.tooltip.borderColor = getCurrentTheme() === 'dark' ? 'rgba(255, 172, 199, 0.6)' : 'rgba(255, 172, 199, 0.8)';
                    // 更新坐标轴文字颜色
                    if (window.topApisChart.options.scales) {
                        if (window.topApisChart.options.scales.x && window.topApisChart.options.scales.x.ticks) {
                            window.topApisChart.options.scales.x.ticks.color = getChartSecondaryTextColor();
                        }
                        if (window.topApisChart.options.scales.y && window.topApisChart.options.scales.y.ticks) {
                            window.topApisChart.options.scales.y.ticks.color = getChartTextColor();
                        }
                    }
                    window.topApisChart.update('none');
                }
                
                // 添加切换动画效果
                themeToggle.style.transform = 'scale(0.9) rotate(180deg)';
                setTimeout(() => {
                    themeToggle.style.transform = '';
                }, 200);
            });
            
            // 监听系统主题变化
            if (window.matchMedia) {
                const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
                mediaQuery.addEventListener('change', function(e) {
                    // 如果用户没有手动设置过主题，则跟随系统
                    if (!localStorage.getItem('theme')) {
                        setTheme(e.matches ? 'dark' : 'light');
                    }
                });
            }
        })();

        // 打开API详情弹窗
        function openApiDetail(name, alias) {
            layui.use('layer', function() {
                var layer = layui.layer;
                layer.open({
                    type: 2,
                    title: name + ' - API详情',
                    shadeClose: true,
                    shade: 0.5,
                    scrollbar: false,
                    maxmin: true,
                    area: ['90%', '90%'],
                    content: '/api/' + alias + '.html',
                    skin: 'layui-layer-molv',
                    // 添加动画效果
                    anim: 5,
                    // 成功打开后的回调
                    success: function(layero, index) {
                        // 可以在这里添加额外的处理逻辑
                    }
                });
            });
        }

        // 获取当前主题
        function getCurrentTheme() {
            return document.documentElement.getAttribute('data-theme') || 'light';
        }

        // 颜色配置 - 卡通风格彩色系列
        const colors = {
            pink: 'rgba(255, 172, 199, 0.7)',
            pinkDark: 'rgba(255, 138, 172, 0.9)',
            blue: 'rgba(112, 161, 255, 0.7)',
            blueDark: 'rgba(72, 121, 255, 0.9)',
            yellow: 'rgba(255, 218, 102, 0.7)',
            yellowDark: 'rgba(255, 196, 0, 0.9)',
            green: 'rgba(121, 255, 153, 0.7)',
            greenDark: 'rgba(72, 219, 103, 0.9)',
            purple: 'rgba(204, 153, 255, 0.7)',
            purpleDark: 'rgba(170, 102, 255, 0.9)',
            orange: 'rgba(255, 179, 102, 0.7)',
            orangeDark: 'rgba(255, 153, 51, 0.9)',
            teal: 'rgba(102, 255, 230, 0.7)',
            tealDark: 'rgba(51, 230, 204, 0.9)',
            red: 'rgba(255, 128, 128, 0.7)',
            redDark: 'rgba(255, 92, 92, 0.9)',
            brown: 'rgba(222, 184, 135, 0.7)',
            brownDark: 'rgba(184, 134, 11, 0.9)',
        };

        // 获取工具提示背景色
        function getTooltipBackground() {
            return getCurrentTheme() === 'dark' ? "rgba(42, 31, 37, 0.95)" : "rgba(255, 255, 255, 0.95)";
        }

        // 获取图表文字颜色
        function getChartTextColor() {
            return getCurrentTheme() === 'dark' ? '#ffffff' : '#6a4b5a';
        }

        // 获取图表次要文字颜色
        function getChartSecondaryTextColor() {
            return getCurrentTheme() === 'dark' ? '#d9c2c9' : '#b298a3';
        }

        // 生成渐变背景
        function createGradient(ctx, color, colorDark) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, color);
            gradient.addColorStop(1, colorDark);
            return gradient;
        }

        // 添加参考线函数
        function addReferenceLines(chart, containerId, values) {
            const container = document.getElementById(containerId);
            container.innerHTML = ''; // 清空现有参考线

            if (!chart) return;

            const yAxis = chart.scales.y;
            const chartArea = chart.chartArea;

            values.forEach(value => {
                const yPos = yAxis.getPixelForValue(value);

                if (yPos >= chartArea.top && yPos <= chartArea.bottom) {
                    const line = document.createElement('div');
                    line.className = 'reference-line';
                    line.style.top = yPos + 'px';

                    const label = document.createElement('div');
                    label.className = 'reference-label';
                    label.style.top = (yPos - 15) + 'px';
                    label.textContent = value.toLocaleString();

                    line.appendChild(label);
                    container.appendChild(line);
                }
            });
        }

        // 最受欢迎API图表 - 使用彩色卡通风格的水平条形图
        <?php if (isset($top_apis) && $top_apis): ?>
            // 为每个API分配独特的彩色
            const apiColors = [
                colors.pink, colors.blue, colors.yellow, colors.green,
                colors.purple, colors.orange, colors.teal, colors.red,
                colors.brown, colors.pinkDark
            ];

            const apiColorsDark = [
                colors.pinkDark, colors.blueDark, colors.yellowDark, colors.greenDark,
                colors.purpleDark, colors.orangeDark, colors.tealDark, colors.redDark,
                colors.brownDark, colors.pink
            ];

            const topApisCtx = document.getElementById('topApisChart').getContext('2d');

            // 创建渐变数组
            const gradients = apiColors.map((color, index) =>
                createGradient(topApisCtx, color, apiColorsDark[index])
            );

            // 初始化图表（使用全局变量以便主题切换时更新）
            window.topApisChart = new Chart(topApisCtx, {
                type: 'bar',
                data: {
                    labels: [<?php echo "'" . implode("','", array_column($top_apis, 'name')) . "'"; ?>],
                    datasets: [{
                        label: '调用次数',
                        data: [<?php echo implode(",", array_column($top_apis, 'views')); ?>],
                        backgroundColor: gradients,
                        borderColor: apiColorsDark,
                        borderWidth: 2,
                        borderRadius: 12,
                        borderSkipped: false,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7,
                    }]
                },
                options: {
                    indexAxis: 'y', // 水平条形图
                    maintainAspectRatio: false,
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce',
                        // 为每个条形添加顺序动画
                        delay: function(context) {
                            return context.dataIndex * 200;
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: getTooltipBackground(),
                            titleColor: getChartTextColor(),
                            bodyColor: getChartTextColor(),
                            borderColor: getCurrentTheme() === 'dark' ? 'rgba(255, 172, 199, 0.6)' : 'rgba(255, 172, 199, 0.8)',
                            borderWidth: 2,
                            padding: 12,
                            cornerRadius: 10,
                            displayColors: false,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return `调用次数: ${context.parsed.x.toLocaleString()}`;
                                },
                                title: function(context) {
                                    return context[0].label;
                                }
                            },
                            // 卡通风格的工具提示动画
                            animation: {
                                duration: 300,
                                easing: 'easeOutElastic'
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: "rgba(255, 172, 199, 0.1)",
                                drawBorder: false
                            },
                            ticks: {
                                color: getChartSecondaryTextColor(),
                                callback: function(value) {
                                    // 格式化大数值为更易读的形式
                                    if (value >= 1000000) {
                                        return (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toFixed(1) + 'K';
                                    }
                                    return value;
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: getChartTextColor(),
                                padding: 15
                            }
                        }
                    },
                    // 交互效果
                    interaction: {
                        mode: 'index',
                        intersect: false,
                        axis: 'y'
                    },
                    // 悬停效果
                    hover: {
                        animationDuration: 300,
                        mode: 'index',
                        intersect: false,
                        onHover: function(e) {
                            const point = this.getElementsAtEventForMode(
                                e,
                                'nearest', {
                                    intersect: true
                                },
                                false
                            );

                            if (point.length) e.target.style.cursor = 'pointer';
                            else e.target.style.cursor = 'default';
                        }
                    }
                }
            });

            // 添加参考线 - 自动计算合适的参考值
            setTimeout(() => {
                const maxValue = Math.max(...[<?php echo implode(",", array_column($top_apis, 'views')); ?>]);
                const step = Math.ceil(maxValue / 5);

                const referenceValues = [step, step * 2, step * 3, step * 4];
                addReferenceLines(window.topApisChart, 'topApisReferenceLines', referenceValues);
            }, 1000);

            // 窗口大小改变时重绘参考线
            window.addEventListener('resize', () => {
                const maxValue = Math.max(...[<?php echo implode(",", array_column($top_apis, 'views')); ?>]);
                const step = Math.ceil(maxValue / 5);

                const referenceValues = [step, step * 2, step * 3, step * 4];
                addReferenceLines(window.topApisChart, 'topApisReferenceLines', referenceValues);
            });
        <?php endif; ?>

        // 添加元素进入视口时的动画
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            // 对所有卡片应用观察器
            document.querySelectorAll('.card').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>

</html>