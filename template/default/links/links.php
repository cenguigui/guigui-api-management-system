<?php

/**
 * 左侧栏
 * 友情链接
 **/
// 引入数据库文件
include("./includes/common.php");
$number = $DB->getColumn("SELECT SUM(views) FROM `api_apilist` WHERE `status`='1'");
$links = $DB->getAll("SELECT * FROM api_youlian ORDER BY id ASC");
?>

<!--侧栏-->
<link rel="stylesheet" href="<?= theme ?>links/css/links.css">
<div class="Guigui_action">
    <div class="Guigui_action_item nav left_nav" title="友情链接">
        <svg t="1736163634333" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="7479" width="20" height="20"><path d="M126.4 896c-17.6 0-32-14.4-32-32 0-41.6 6.4-81.6 20.8-120 6.4-16 24-25.6 41.6-19.2 16 6.4 25.6 24 19.2 41.6-11.2 30.4-17.6 64-17.6 97.6 0 17.6-14.4 32-32 32zM504 531.2c84.8-30.4 144-110.4 144-204.8 0-120-97.6-217.6-217.6-217.6s-217.6 97.6-217.6 217.6c0 94.4 60.8 174.4 144 204.8-72 16-136 56-184 115.2-11.2 14.4-9.6 33.6 4.8 44.8 14.4 11.2 33.6 9.6 44.8-4.8 51.2-64 128-99.2 208-99.2 150.4 0 272 124.8 272 276.8 0 17.6 14.4 32 32 32s32-14.4 32-32c0-163.2-112-299.2-262.4-332.8zM276.8 324.8c0-84.8 68.8-153.6 153.6-153.6s153.6 68.8 153.6 153.6-68.8 153.6-153.6 153.6-153.6-67.2-153.6-153.6z" fill="#0078E5" p-id="7480"></path><path d="M755.2 505.6c56-41.6 89.6-107.2 89.6-179.2 0-97.6-65.6-185.6-160-212.8-17.6-4.8-35.2 4.8-40 22.4-4.8 17.6 4.8 35.2 22.4 40 67.2 19.2 113.6 81.6 113.6 152s-46.4 132.8-113.6 152c-12.8 1.6-24 11.2-27.2 25.6V518.4c0 1.6 0 1.6 1.6 1.6 0 1.6 1.6 1.6 1.6 3.2 4.8 9.6 14.4 16 25.6 17.6 112 24 193.6 126.4 193.6 244.8 0 17.6 14.4 32 32 32s32-14.4 32-32c0-120-67.2-227.2-171.2-280z" fill="#17FFFF" p-id="7481"></path>
        </svg>
        <!-- 鼠标悬停时显示的文字 -->
        <div class="text">友情链接</div>
    </div>
    <div class="Guigui_nav">
        <div class="Guigui_nav_title">
            <nav>
                <?= $system['sysname'] ?>
            </nav>
            <div class="Guigui_nav_gaunbi">
                <!--向左-->
                <svg t="1736164503509" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="21508" width="32" height="32"><path d="M470.816 267.52a32 32 0 0 1 47.936 42.24l-2.688 3.008-199.68 199.648 208.672 208.64a32 32 0 0 1 2.656 42.24l-2.656 3.008a32 32 0 0 1-42.24 2.688l-3.008-2.688-231.264-231.264a32 32 0 0 1-2.688-42.24l2.688-3.008 222.272-222.272z" fill="#D20A10" p-id="21509"></path><path d="M726.816 267.52a32 32 0 0 1 47.936 42.24l-2.688 3.008-199.68 199.648 208.672 208.64a32 32 0 0 1 2.656 42.24l-2.656 3.008a32 32 0 0 1-42.24 2.688l-3.008-2.688-231.264-231.264a32 32 0 0 1-2.688-42.24l2.688-3.008 222.272-222.272z" fill="#000000" p-id="21510"></path>
                </svg>
            </div>
        </div>
        <blog-cenguigui-cn-nav id="box_nav">
            
            <!-- <img src="https://api.cenguigui.cn/api/tongji/?t=2" title="统计"> -->
            <nav>
                隔壁舍友
            </nav>
            <div class="links_box">
                <?php foreach ($links as $item) { ?>
                    <div class="links_box_card">
                        <ul class="links_box_card_list">
                            <li>
                                <img class="avatar" src="<?= $item['icon'] ?>" data-src="<?= $item['icon'] ?>">
                            </li>
                            <li>
                                <dl>
                                    <dt>
                                        <a target="_blank" href="<?= $item['domain'] ?>" title="<?= $item['content'] ?>">
                                            <?= $item['title'] ?>
                                        </a>
                                    </dt>
                                    <dd class="avatar-dest em09 muted-3-color text-ellipsis">
                                        <?= $item['content'] ?>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            
            <nav>
                API交流群
            </nav>
            
            <div class="links_box_card"><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/AVVZ4SC0yk">
                </a>
                <ul class="links_box_card_list"><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/AVVZ4SC0yk">
                        <li>
                            <img class="avatar" src="https://p.qlogo.cn/gh/914956181/914956181/0" data-src="https://p.qlogo.cn/gh/914956181/914956181/0">
                        </li>
                    </a>
                    <li><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/AVVZ4SC0yk">
                        </a>
                        <dl><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/AVVZ4SC0yk">
                            </a>
                            <dt><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/AVVZ4SC0yk">
                                </a><a target="_blank" href="https://qm.qq.com/q/AVVZ4SC0yk" title="交流和反馈api问题，群文件也有开源api哦!">
                                    【逸万片星空(龙珠/笒鬼鬼API)】(大群) </a>
                            </dt>
                            <dd class="avatar-dest em09 muted-3-color text-ellipsis">
                                交流和反馈api问题，群文件也有开源api哦! </dd>
                        </dl>
                    </li>
                </ul>
            </div>
            
            <div class="links_box_card"><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/eaSjCxnvIA">
                </a>
                <ul class="links_box_card_list"><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/eaSjCxnvIA">
                        <li>
                            <img class="avatar" src="https://p.qlogo.cn/gh/443126544/443126544/0" data-src="https://p.qlogo.cn/gh/443126544/443126544/0">
                        </li>
                    </a>
                    <li><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/eaSjCxnvIA">
                        </a>
                        <dl><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/eaSjCxnvIA">
                            </a>
                            <dt><a target="_blank" class="avatar-img link-img" href="https://qm.qq.com/q/eaSjCxnvIA">
                                </a><a target="_blank" href="https://qm.qq.com/q/eaSjCxnvIA" title="交流和反馈api问题，群文件也有开源api哦!">
                                    笒鬼鬼API交流群(小群) </a>
                            </dt>
                            <dd class="avatar-dest em09 muted-3-color text-ellipsis">
                                交流和反馈api问题，群文件也有开源api哦! </dd>
                        </dl>
                    </li>
                </ul>
            </div>

        </blog-cenguigui-cn-nav>
    </div>
    <div class="Guigui_action_item mode">
        <!--夜晚-->
        <svg t="1736164369568" class="iconfont Guigui-icon-yewan icon-1" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3538" width="20" height="20"><path d="M447.449946 25.038001c-17.785327 0-35.336966 0.963963-52.609013 2.841813 168.221984 60.028608 288.646424 220.735019 288.646424 409.57997 0 240.131123-194.653767 434.776545-434.776545 434.776545-56.156064 0-109.804154-10.649497-159.09146-30.012218 88.964191 96.362921 216.37006 156.746234 357.851459 156.746234 268.937344 0 486.951566-218.018395 486.951567-486.959912C934.405686 243.06057 716.38729 25.038001 447.449946 25.038001z" fill="#FFF278" p-id="3539"></path><path d="M66.530142 276.227575h150.228007v33.384002h-150.228007z" fill="#6E6E96" p-id="3540"></path><path d="M124.952145 211.546072h33.384002v227.428511h-33.384002z" fill="#6E6E96" p-id="3541"></path><path d="M534.169064 29.369575c199.63633 53.418576 345.98762 227.77487 345.991792 434.63049 0 249.3618-212.631052 451.489411-474.929153 451.489411-79.558249 0-154.53037-18.640792-220.401178-51.524034a432.50226 432.50226 0 0 1-99.400865-25.935196c88.964191 96.362921 216.37006 156.746234 357.851459 156.746234 268.937344 0 486.951566-218.018395 486.951567-486.959913 0-237.861011-170.571383-435.865698-396.063622-478.446992z" fill="#FFD978" p-id="3542"></path><path d="M285.591788 580.280716h119.898641v33.384001H285.591788z" fill="#6E6E96" p-id="3543"></path><path d="M328.849108 532.015795h33.384001v181.525509h-33.384001z" fill="#6E6E96" p-id="3544"></path><path d="M447.462465 1011.480999c-140.09179 0-274.992367-59.08551-370.111733-162.116884a16.687828 16.687828 0 0 1 18.369547-26.861603c48.728123 19.149898 100.202081 28.860469 152.98636 28.86047 230.533223 0 418.084544-187.547148 418.084544-418.084544 0-176.338469-111.544295-334.62454-277.567108-393.860278a16.692001 16.692001 0 0 1 3.814122-32.315714C411.044693 5.162001 429.347472 4.173 447.449946 4.173c277.713163 0 503.64774 225.93875 503.656087 503.64774 0 277.721509-225.934577 503.660259-503.643568 503.660259zM153.36193 874.681707c82.917514 66.342357 186.883641 103.415291 294.100535 103.415291 259.310232 0 470.259566-210.961852 470.259566-470.267912-0.008346-252.804525-200.529352-459.655972-450.859288-469.875649 141.977986 78.50248 233.308268 229.523357 233.308269 395.333347 0 248.936154-202.528219 451.468546-451.468546 451.468545-32.328233 0-64.205781-3.375957-95.340536-10.073622z" fill="#6E6E96" p-id="3545"></path>
        </svg>
        <!--白天-->
        <svg t="1736164337582" class="iconfont Guigui-icon-baitian2 icon-2" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="18596" width="20" height="20"><path d="M571.5 552.5m-242 0a242 242 0 1 0 484 0 242 242 0 1 0-484 0Z" fill="#F7D134" p-id="18597"></path><path d="M531 770a258 258 0 1 1 182.43-75.57A256.31 256.31 0 0 1 531 770z m0-484c-124.62 0-226 101.38-226 226s101.38 226 226 226 226-101.38 226-226-101.38-226-226-226z" fill="" p-id="18598"></path><path d="M531 212.11a12 12 0 0 1-12-12V80a12 12 0 0 1 24 0v120.11a12 12 0 0 1-12 12zM310.46 303.46a12 12 0 0 1-8.49-3.52L217 215a12 12 0 0 1 17-17l84.94 85a12 12 0 0 1-8.48 20.49zM219.11 524H99a12 12 0 0 1 0-24h120.11a12 12 0 0 1 0 24zM225.53 829.47A12 12 0 0 1 217 809l85-84.94a12 12 0 1 1 17 17L234 826a12 12 0 0 1-8.47 3.47zM531 956a12 12 0 0 1-12-12V823.89a12 12 0 1 1 24 0V944a12 12 0 0 1-12 12zM836.47 829.47A12 12 0 0 1 828 826l-84.94-85a12 12 0 0 1 17-17L845 809a12 12 0 0 1-8.49 20.49zM963 524H842.89a12 12 0 1 1 0-24H963a12 12 0 0 1 0 24zM751.54 303.46a12 12 0 0 1-8.48-20.46L828 198a12 12 0 0 1 17 17l-85 84.94a12 12 0 0 1-8.46 3.52z" fill="" p-id="18599"></path></svg>
        <!-- 鼠标悬停时显示的文字 -->
        <div class="text">黑暗交替</div>
    </div>
</div>
<script src="<?= theme ?>links/js/links.js"></script>