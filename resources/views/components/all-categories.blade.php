<div>
    <div class="agileits-navi_search">
        <form action="#" method="post">
            <select id="agileinfo-nav_search" name="agileinfo_search" class="border" required="">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{$category->slug}}">{{$category->title}}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>