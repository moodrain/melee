@extends('layout.app')

@section('title')
@endsection

@section('html')
    <div id="loading" style="position: absolute;z-index: 3000;background: #b4f3f4;width: 100%;height: 100%"></div>
    @if(mobile())

        <div id="app">

            <el-container style="height: 100%;width: 100%;">

                <el-header style="height: 60px;width: 100%;padding: 0;overflow: hidden;background: #545c64;text-align: right">

                    <div style="float: left;color: white;height: 60px;width: 100px;line-height: 60px;font-size: 1.5em">MELEE</div>

                    <el-menu style="height: 100%;width: max-content;display: inline-block" :default-active="menuActive" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b" mode="horizontal">

                        @include('layout.frame-nav')

                    </el-menu>

                </el-header>

                <el-main ref="main" style="width: 100%;height: 100%;background: #b4f3f4;overflow: scroll;">
                    @yield('main')
                </el-main>

                @if(config('app.url') == 'https://blog.moodrain.cn')
                <el-footer style="height: 60px;background: #b4f3f4;padding: 0;color: white">
                    <div style="height: 40px;margin-top: 25px;background: black;padding-top: 10px;text-align: center">
                        <a style="color: white" id="ICP" href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备16040215号-2</a>
                        <el-divider direction="vertical"></el-divider>
                        <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/" style="color: white;vertical-align: top">
                            <img alt="知识共享许可协议" src="https://s1.moodrain.cn/img/by-nc-nd.png" />
                        </a>

                    </div>
                </el-footer>
                @endif

            </el-container>

        </div>

    @else

        <div id="app">
            <el-container style="height: 100%">

                <el-aside style="width: 300px;height: 100%;overflow: hidden">

                    <el-menu style="height: 100%;width: 100%" :default-active="menuActive" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">

                        <el-container style="width: 100%;height: 100px;line-height: 100px;">
                            <p style="font-family: sans-serif;color: white;font-size: 2em;width: 100%;text-align: center;user-select: none">{{ strtoupper(config('app.name')) }}</p>
                        </el-container>

                        @include('layout.frame-nav')

                    </el-menu>

                </el-aside>

                <el-container>

                    </el-header>

                    <el-main ref="main" style="width: 100%;height: 100%;background: #b4f3f4;overflow: scroll;">
                        @yield('main')
                    </el-main>

                    @if(config('app.url') == 'https://blog.moodrain.cn')
                    <el-footer style="height: 60px;background: #b4f3f4;padding: 0;color: white">
                        <div style="height: 40px;margin-top: 25px;background: black;padding-top: 10px;text-align: center">
                            <a style="color: white" id="ICP" href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备16040215号-2</a>
                            <el-divider direction="vertical"></el-divider>
                            <span>本作品采用</span>
                            <a style="color: white" rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">知识共享署名-非商业性使用-禁止演绎 3.0 未本地化版本许可协议</a>
                            <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/" style="color: white;vertical-align: top;">
                                <img alt="知识共享许可协议" src="https://s1.moodrain.cn/img/by-nc-nd.png" />
                            </a>
                            <span>进行许可</span>
                        </div>
                    </el-footer>
                    @endif

                </el-container>

            </el-container>
        </div>

    @endif

    <form hidden id="logout" action="/logout" method="POST"></form>

@endsection



@section('js')
    @include('layout.js')
    @yield('script')
@endsection

@section('css')
    @include('layout.css')
    @yield('style')
@endsection