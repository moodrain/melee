@extends('layout.frame')

@section('title', $post->title)

@section('main')
    <el-row>
        <el-col :xs="{span:24,offset:0}" :span="14" :offset="3">
            <br />

            <el-card style="padding: 20px;" class="mdui-typo content" >
                <h3 style="margin-top: 0;">@{{ title }}</h3>
                <el-row v-if="tags.length > 0">
                    <el-col :span="16">
                        <div>
                            <span v-for="(tag, index) in tags" :key="tag.id">
                                <el-divider direction="vertical" v-if="index !== 0"></el-divider>
                                <a :href="'/?tag=' + tag.name">@{{ tag.name }}</a>
                            </span>
                        </div>
                    </el-col>
                    <el-col :span="8">
                        <div class="post-date">{{ $post->createdAtReadable }}</div>
                    </el-col>
                </el-row>
                <div v-if="tags.length === 0" class="post-date">{{ $post->createdAtReadable }}</div>
                @if(count($post->series->posts ?? []) > 1)
                <div>
                    <br />
                    <el-collapse value="default">
                        <el-collapse-item name="default" title="{{ $post->series->name }} 系列的文章列表">
                            <div v-for="(post, index) in series.posts" :key="post.id">@{{ index + 1 }}. <a :href="'/post/' + post.id">@{{ post.title }}</a></div>
                        </el-collapse-item>
                    </el-collapse>
                </div>
                @else
                <el-divider></el-divider>
                @endif
                <div v-html="$marked(content)"></div>
            </el-card>
            <br />

            <el-card>
                <div slot="header" style="width: 100%">
                    <el-row>
                        <el-col :span="16">
                            留言
                        </el-col>
                        <el-col :span="8" style="text-align: right">
                            <el-button v-if="! showForm" size="small" icon="el-icon-plus" @click="(showForm = true) && $refs.main.$el.scroll({top: 100000, behavior: 'smooth'})"></el-button>
                        </el-col>
                    </el-row>
                </div>
                <el-card shadow="none" v-if="showForm">
                    <el-form>
                        <x-input exp="model:form.userName;pre:名称;holder:可选" />
                        <x-input exp="model:form.userEmail;pre:邮箱;holder:可选，不会展示，联系用" />
                        <x-input exp="model:form.content;type:textarea;row:4" />
                        <el-button @click="submit">提交留言</el-button>
                    </el-form>
                </el-card>
                <div v-for="(comment, index) in comments" :key="comment.id">
                    <el-divider v-if="index !== 0"></el-divider>
                    <div class="mdui-typo content" v-html="$marked($decodeBase64(comment.contentBase64))"></div>
                    <el-row>
                        <el-col :span="16">
                            <div style="font-size: .9em">@{{ comment.userName }}</div>
                        </el-col>
                        <el-col :span="8">
                            <div class="post-date">@{{ comment.createdAtReadable }}</div>
                        </el-col>
                    </el-row>
                </div>
            </el-card>
        </el-col>
    </el-row>
    <x-image-preview></x-image-preview>
    <x-totop></x-totop>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            data () {
                return {
                    @include('piece.data')
                    menuActive: '{{ $post->id == 1 ? 'about' : 'post' }}',
                    title: '{{ $post->title }}',
                    tags: @json($post->tags),
                    content: $decodeBase64('{{ $post->contentBase64 }}'),
                    comments: @json($post->comments),
                    form: {
                        postId: {{ $post->id }},
                        userName: '',
                        userEmail: '',
                        content: '',
                    },
                    showForm: false,
                    series: @json($post->series),
                }
            },
            methods: {
                @include('piece.method')
                submit() {
                    this.$submit('/comment', this.form)
                }
            },
            mounted() {
                @include('piece.init')
            }
        })
    </script>
@endsection