<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $count['user'] }}</h3>

                <p>用户总数</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{ admin_base_path('users') }}" class="small-box-footer">用户列表 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $count['product'] }}</h3>

                <p>产品总数</p>
            </div>
            <div class="icon">
                <i class="fa fa-product-hunt"></i>
            </div>
            <a href="{{ admin_base_path('products') }}" class="small-box-footer">产品列表 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $count['article'] }}</h3>

                <p>资讯总数</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-text"></i>
            </div>
            <a href="{{ admin_base_path('articles') }}" class="small-box-footer">资讯列表 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $count['feedback'] }}</h3>

                <p>留言总数</p>
            </div>
            <div class="icon">
                <i class="fa fa-commenting"></i>
            </div>
            <a href="{{ admin_base_path('feedback') }}" class="small-box-footer">留言列表 <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>