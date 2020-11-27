{{-- {{dd($mainMenuCategories)}} --}}
@foreach($mainMenuCategories as $menuCategory)
@if(count($menuCategory)>0)
    <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{$menuCategory['title']}}
        </a>
        <div class="dropdown-menu">
            <div class="agile_inner_drop_nav_info p-4">
                <h5 class="mb-3">{{$menuCategory['title']}}</h5>
                <div class="row">
                    <div class="col-sm-6 multi-gd-img">
                        <ul class="multi-column-dropdown">
                        	@foreach($menuCategory['childs'] as $childCategory)
                            <li>
                                <a href="{{route('products',$childCategory['slug'])}}">{{$childCategory['title']}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- <div class="col-sm-6 multi-gd-img">
                        <ul class="multi-column-dropdown">
                            <li>
                                <a href="product.html">Laptops</a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </li>
@else    
    <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
        <a class="nav-link" href="{{route('products',$menuCategory['slug'])}}">{{$menuCategory['title']}}</a>
    </li>
@endif
@endforeach    
    
