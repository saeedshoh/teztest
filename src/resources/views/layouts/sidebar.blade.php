<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Меню</li>
                @role('admin')
                    <li>
                        <a href="/" class=" waves-effect">
                            <i class="bx bx-file"></i>
                            <span>Главная страница</span>
                        </a>
                    </li>
                    <li>
                        <a href="/complaints" class=" waves-effect">
                            <i class="bx bx-file"></i>
                            <span>Обратная связь</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxl-product-hunt"></i>
                            <span>Товары</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/products/create">Добавить</a></li>
                            <li><a href="/products">Товары</a></li>
                            <li><a href="/products?product_status=PENDING">Модерация</a></li>
                            <li><a href="/products/categories">Категории</a></li>
                            <li><a href="/products/brands">Бренды</a></li>
                            <li><a href="javascript: void(0);" class="has-arrow">Опции</a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="/products/option_values">Значении опции</a></li>
                                    <li><a href="/products/option_types">Типы опции</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-store"></i>
                            <span>Магазины</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/shops/">Все магазины</a></li>
                            <li><a href="/shops/create">Создать магазин</a></li>
                            <li><a href="/shops/shop_categories">Категории магазинов</a></li>
                        </ul>
                    </li>

                    {{--<li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-truck"></i>
                            <span>Службы доставки</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/delivery_agencies/">Все</a></li>
                            <li><a href="/delivery_agencies/create">Создать</a></li>
                        </ul>
                    </li>--}}

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-cart"></i>
                            <span>Заказы</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/orders/">Все заказы</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-user"></i>
                            <span>Пользователи</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/users/">Все пользователи</a></li>
                            <li><a href="/users/create">Добавить пользователя</a></li>
                            <li><a href="/roles">Роли</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="/logs" class=" waves-effect">
                            <i class="bx bxs-error-alt"></i>
                            <span>Логи</span>
                        </a>
                    </li>
                @endrole
                @role('merchant')
                    <li>
                        <a href="/shops/my_shop" class=" waves-effect">
                            <i class="bx bx-file"></i>
                            <span>Главная страница</span>
                        </a>
                    </li>
                    <li>
                        <a href="/products/create" class=" waves-effect">
                            <i class="bx bx-file"></i>
                            <span>Добавить товар</span>
                        </a>
                    </li>
                    <li>
                        <a href="/products/shop" class=" waves-effect">
                            <i class="bx bx-file"></i>
                            <span>Мои товары</span>
                        </a>
                    </li>
                @endrole

                @role('operator')
                <li>
                    <a href="/" class=" waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Главная страница</span>
                    </a>
                </li>
                <li>
                    <a href="/products/table" class=" waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Товары</span>
                    </a>
                </li>
                <li>
                    <a href="/orders" class=" waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Заказы</span>
                    </a>
                </li>
                @endrole

                @role('moderator')
                <li>
                    <a href="/products/table" class=" waves-effect">
                        <i class="bx bx-file"></i>
                        <span>Товары</span>
                    </a>
                </li>
                <li><a href="/products?product_status=PENDING">Модерация</a></li>
                @endrole
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
