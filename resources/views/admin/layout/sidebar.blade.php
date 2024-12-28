<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo my-3">
      <a href="{{route('admin.dashboard')}}" class="app-brand-link w-80px h-100px">
        <img src="{{asset('assets/img/logo-sidebar.png')}}" class="object-fit-contain"  alt="">
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
        <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
      </a>
    </div>



    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">



      {{-- <!-- Apps & Pages -->
      <li class="menu-header small text-uppercase"><span class="menu-header-text">برنامه‌ها و صفحات</span></li> --}}
      <li class="menu-item @if($current_routename == "admin.dashboard") active @endif">
        <a href="{{route('admin.dashboard')}}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-envelope"></i>
          <div>داشبورد</div>
        </a>
      </li>
      @foreach($sidebar_menus as $menu)
      @php
        $active_head_menu=strpos($current_routename,$menu['name'])!==false;
      @endphp
      @if(isset($menu['children']))
        @checkHasPermission($menu['name'].".*")
        <li class="menu-item @if($active_head_menu) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-food-menu"></i>
            <div data-i18n="Invoice">{{__("permissions.".$menu['slug'])}}</div>
            </a>
            <ul class="menu-sub">
            @foreach($menu['children'] as $children)
            @php
                $submenu_array_routename=explode(".",$children['name']);
                $prefix=[];

                foreach($submenu_array_routename as $key=>$item)
                {
                    if($key < count($submenu_array_routename) - 1)
                        $prefix[]=$item;
                }
                $prefix=implode(".",$prefix).".";
                $active_submenu=strpos($current_routename,$prefix) !== false;
            @endphp
            @checkHasPermission($children['name'])
            @if(checkRouteExist($children['name']))
            <li class="menu-item @if($active_submenu) active @endif">
                <a href="{{route($children['name'])}}" class="menu-link">
                <div>{{__("permissions.".$children['slug'])}}</div>
                </a>
            </li>
            @endif
            @endcheckHasPermission
            @endforeach
            </ul>
        </li>
        @endcheckHasPermission
      @else
      @checkHasPermission($menu['name'])
      @if(checkRouteExist($menu['name']))
        <li class="menu-item ">
            <a href="{{route($menu['slug'])}}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-chat"></i>
            <div>{{__("permissions.".$menu['slug'])}}</div>
            </a>
        </li>
      @endif
      @endcheckHasPermission
      @endif
      @endforeach







    </ul>
  </aside>
  <!-- / Menu -->
