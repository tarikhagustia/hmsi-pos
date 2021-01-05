<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="#">{{ env('APP_NAME') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="#">{{ strtoupper(substr(env('APP_NAME'), 0, 2)) }}</a>
    </div>
    <ul class="sidebar-menu">
        {!! \App\Libraries\Menu\SidebarMenu::generate() !!}
    </ul>
</aside>
