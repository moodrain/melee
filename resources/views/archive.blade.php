@extends('layout.frame')

@section('title', '归档')

@section('main')
    <el-row>
        <el-col :xs="{span:24,offset:0}" :span="14" :offset="3">
            <br />
            <el-card>
                <p slot="header" style="font-size: 1.25em">标签</p>
                <div class="mdui-typo">
                    <span v-for="(tag, index) in tags" :key="tag.id">
                        <el-divider direction="vertical" v-if="index !== 0"></el-divider>
                        <a :href="'/?tag=' + tag.name">@{{ tag.name }}</a>
                    </span>
                </div>
            </el-card>

            <br />
            <el-card>
                <p slot="header" style="font-size: 1.25em">系列</p>
                <div class="mdui-typo">
                    <span v-for="(s, index) in series" :key="s.id">
                        <el-divider direction="vertical" v-if="index !== 0"></el-divider>
                        <a :href="'/?series=' + s.name">@{{ s.name }}</a>
                    </span>
                </div>
            </el-card>

            <br />
            <el-card>
                <p slot="header" style="font-size: 1.25em">友链</p>
                <div class="mdui-typo">
                    <span v-for="(link, index) in links" :key="link.id">
                        <el-divider direction="vertical" v-if="index !== 0"></el-divider>
                        <a :href="link.url">@{{ link.name }}</a>
                    </span>
                </div>
            </el-card>

            <br />
            <el-card>
                <p slot="header" style="font-size: 1.25em">归档</p>
                <div class="mdui-typo">
                    <p>总计：@{{ postTotal }}</p>
                    <div v-for="year in posts" :key="year.year">
                        <el-divider content-position="left">@{{ year.year }}<el-divider direction="vertical"></el-divider>@{{ year.posts.length }}</el-divider>
                        <el-timeline>
                            <el-timeline-item v-for="post in year.posts" :key="post.id" :timestamp="post.createdAtDate" placement="top">
                                <el-card>
                                    <a :href="'/post/' + post.id">@{{ post.title }}</a>
                                </el-card>
                            </el-timeline-item>
                        </el-timeline>
                    </div>
                </div>
            </el-card>
        </el-col>
    </el-row>
    <x-totop></x-totop>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            data () {
                return {
                    @include('piece.data')
                    menuActive: 'archive',
                    tags: @json($tags),
                    series: @json($series),
                    links: @json($links),
                    posts: @json($posts),
                }
            },
            methods: {
                @include('piece.method')
            },
            mounted() {
                @include('piece.init')
            },
            computed: {
                postTotal: {
                    get() {
                        let total = 0
                        this.posts.forEach(y => {
                            y.posts.forEach(p => {
                                total++
                            })
                        })
                        return total
                    }
                }
            }
        })
    </script>
@endsection

@section('style')
    <style>
        ul li {
            list-style-type: none;
        }
    </style>
@endsection