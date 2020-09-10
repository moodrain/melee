@extends('admin.layout.frame')

@section('title', 'Melee 后台')

@section('main')
    <el-row>
        <el-col :xs="24" :span="8">
            <br />
            <el-card>
                <el-row>
                    <el-col :span="12">月访问</el-col>
                    <el-col :span="12">{{ $visitMonth }}</el-col>
                </el-row>
                <el-divider></el-divider>
                <el-row>
                    <el-col :span="12">总访问</el-col>
                    <el-col :span="12">{{ $visitTotal }}</el-col>
                </el-row>
                <el-divider></el-divider>
                <el-row>
                    <el-col :span="12">月评论</el-col>
                    <el-col :span="12">{{ $commentMonth }}</el-col>
                </el-row>
                <el-divider></el-divider>
                <el-row>
                    <el-col :span="12">总评论</el-col>
                    <el-col :span="12">{{ $commentTotal }}</el-col>
                </el-row>
            </el-card>

            <br />
            <el-card>
                <p slot="header">访问前十文章</p>
                <el-table :data="postsTop">
                    <el-table-column prop="title" label="标题"></el-table-column>
                    <el-table-column prop="visit" label="访问"></el-table-column>
                </el-table>
            </el-card>
        </el-col>
    </el-row>
@endsection

@section('script')
<script>
new Vue({
    el: '#app',
    data () {
        return {
            @include('admin.piece.data')
            menuActive: 'dashboard',
            postsTop: @json($postsTop),
        }
    },
    methods: {
        @include('admin.piece.method')
    },
    mounted() {
        @include('admin.piece.init')
    },
})
</script>
@endsection