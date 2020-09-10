
@extends('layout.frame')

@section('title', config('app.name'))

@section('main')
    <el-row>
        <el-col :xs="{span:24,offset:0}" :span="14" :offset="3">

            <el-card v-if="$query('tag')">
                <p>
                    <span>标签 @{{ $query('tag') }} 的搜索结果</span>
                    <el-divider direction="vertical"></el-divider>
                    <a href="/" style="color: gray">取消搜索</a>
                </p>
            </el-card>

            <el-card v-if="$query('series')">
                <p>
                    <span>系列 @{{ $query('series') }} 的搜索结果</span>
                    <el-divider direction="vertical"></el-divider>
                    <a href="/" style="color: gray">取消搜索</a>
                </p>
            </el-card>

            <el-card class="post" v-for="post in posts" :key="post.id">
                <div class="mdui-typo">
                    <h4 style="margin-top: 0;margin-bottom: 2px;"><a style="color: black" :href="'/post/' + post.id" target="_blank">@{{ post.title }}</a></h4>
                    <el-row v-if="post.tags.length > 0">
                        <el-col :span="16">
                            <div>
                                <span v-if="post.series">
                                    <a :href="'/?series=' + post.series.name">@{{ post.series.name }}</a>
                                    <el-divider direction="vertical" v-if="post.tags.length > 0"></el-divider>
                                </span>
                                <span v-for="(tag, index) in post.tags" :key="tag.id">
                                    <el-divider direction="vertical" v-if="index !== 0"></el-divider>
                                    <a :href="'/?tag=' + tag.name">@{{ tag.name }}</a>
                                </span>
                            </div>
                        </el-col>
                        <el-col :span="8">
                            <div class="post-date">@{{ post.createdAtReadable }}</div>
                        </el-col>
                    </el-row>
                    <div v-if="post.tags.length === 0" class="post-date">@{{ post.createdAtReadable }}</div>
                    <div class="post-content" style="margin-top: 5px;">
                        <div v-html="renderContent(post.contentBase64)"></div>
                    </div>
                    <div style="font-size: 1.5em;margin-top: 2px;">...</div>
                </div>
            </el-card>

            <br />
            <el-card>
                <x-pager :size="10"></x-pager>
            </el-card>

        </el-col>
    </el-row>
    <x-totop></x-totop>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    @include('piece.data')
                    menuActive: 'post',
                    posts: @json($pager->all()),
                    page: {{ $pager->currentPage() }},
                    total: {{ $pager->total() }},
                }
            },
            methods: {
                @include('piece.method')
                renderContent(base64) {
                    return this.$marked($decodeBase64(base64))
                }
            },
            mounted() {
                @include('piece.init')
            }
        })
    </script>
@endsection