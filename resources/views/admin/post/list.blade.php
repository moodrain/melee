@extends('admin.layout.frame')

@include('admin.piece.list-title')

@section('main')
<el-card>
    <el-form inline>
        <x-input exp="model:search.id;pre:ID" />
        <x-input exp="model:search.title;pre:标题" />
        <x-sort />
        <x-admin.list-head-btn :m="$m" />
    </el-form>
</el-card>
<br />
<el-card>
    <el-table :data="list" height="560" border  @selection-change="selectChange">
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column prop="id" label="ID" width="60"></el-table-column>
        <el-table-column prop="title" label="标题"></el-table-column>
        <el-table-column prop="contentShort" label="内容"></el-table-column>
        <el-table-column label="标签">
            <template slot-scope="scope">
                <el-tag v-for="tag in scope.row.tags" :key="tag.id">@{{ tag.name }}</el-tag>
            </template>
        </el-table-column>
        <el-table-column prop="series.name" label="系列"></el-table-column>
        <el-table-column prop="commentsCount" label="评论" width="55"></el-table-column>
        <el-table-column prop="createdAt" label="时间" width="160"></el-table-column>
        <x-admin.list-body-col :m="$m" />
    </el-table>
    <x-pager />
</el-card>
@endsection

@section('script')
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                @include('admin.piece.list-data')
            }
        },
        methods: {
            @include('admin.piece.list-method')
        },
        mounted() {
            @include('admin.piece.init')
        }
    })
</script>
@endsection