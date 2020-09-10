@extends('admin.layout.frame')
@include('admin.piece.edit-title')

@section('main')
    <el-row>
        <el-col :span="8" :xs="24">
            <el-card>
                <el-form>
                    <x-admin.edit-id :d="$d" />
                    <x-input exp="model:form.title;pre:标题" />
                    <x-select exp="model:form.tags;label:标签;key:id;selectLabel:name;value:id;data:tags;multiple:1" />
                    <x-select exp="model:form.series_id;label:系列;key:id;selectLabel:name;value:id;data:series" />
                    <x-input exp="model:form.content;label:内容;type:textarea;row:20" />
                    <el-card>
                            <div style="display: inline-block;width: 20%">上传图片</div>
                            <div style="display: inline-block;width: 20%;text-align: center">
                                <el-upload multiple action="/admin/post/image/upload" :on-success="uploadOk" :show-file-list="false" :with-credentials="true" accept="image/*">
                                    <el-button slot="trigger" icon="el-icon-upload2" size="small"></el-button>
                                </el-upload>
                            </div>
                            <div style="display: inline-block;width: 56%">
                                <el-input v-model="imgToRm">
                                    <template slot="append">
                                        <el-button icon="el-icon-close" @click="removeImage"></el-button>
                                    </template>
                                </el-input>
                            </div>
                    </el-card>
                    <br />
                    <x-admin.edit-submit :d="$d" />
                </el-form>
            </el-card>
        </el-col>
        <el-col :span="8" :offset="1" :xs="{span:24,offset:0}" @if(mobile()) style="margin-top: 20px" @endif>
            <div style="height: 855px;overflow-y: scroll">
                <el-card>
                    <p slot="header">预览</p>
                    <div class="mdui-typo content" v-html="$marked(form.content)"></div>
                </el-card>
            </div>
        </el-col>
    </el-row>
    <x-image-preview />
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                @include('admin.piece.edit-data')
                form: {
                    id: {{ bv('id', null) }},
                    title: '{{ bv('title') }}',
                    tags: @json(bv('tags')),
                    series_id: {{ bv('series_id', null) }},
                    content: $decodeBase64('{{ old('content') ? base64_encode(old('content')) : bv('contentBase64') }}')
                },
                tags: @json(\App\Models\Tag::query()->get(['id', 'name'])),
                series: @json(\App\Models\Series::query()->get(['id', 'name'])),
                imgToRm: '',
            }
        },
        methods: {
            @include('admin.piece.edit-method')
            uploadOk(rs) {
                if (rs.code === 0) {
                    let img = rs.data
                    this.form.content += ('\n\n![](' + img + ')')
                } else {
                    this.$notify.error(rs.msg)
                }
            },
            removeImage() {
                this.$fet('/admin/post/image/remove', {file: this.imgToRm}, 'post').then(rs => {
                    if (rs.code === 0) {
                        this.imgToRm = ''
                    } else {
                        this.$notify.error(rs.msg)
                    }
                })
            }
        },
        mounted() {
            @include('admin.piece.init')
        }
    })
</script>
@endsection
