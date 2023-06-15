<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="icon" type="image/x-icon" href="/sample-icon.ico" />     <!-- 原本我试了很多次添加icon图标不成功，后来教材里一句“laravel是以public文件夹为根目录的”，这下我就明白了，以上的路径就对了 -->
    
    <title>@yield('title', '缺省值-缺省默认的title') --接在缺省（若需要）后面的模板页的统一的title</title>      <!-- <title>Weibo App</title>的优化形式 -->

    <!-- <link rel="stylesheet" href="/css/app.css"> -->
    <!-- 所以这里引入的css样式表也是以public为根目录的，即/css/app.css就是public/css/app.css -->
    <!-- 上面引入样式表的写法再进一步就变成下面这种↓ 因为教材4.4小节在webpack.mix.js里面加了能够动态修改缓存的代码 -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>


  <body>
    
    @include('layouts._header_nav')



    <div class="container">
      <div class="offset-md-1 col-md-10">

        @include('parts._messages')

        @yield('content')

        @include('layouts._footer')
      </div>
    </div>


    <script src="{{ mix('js/app.js') }}"></script>  <!-- 这行不加的话，加载到resources/js/app.js里的代码就不会生效  -->
  </body>

</html>
