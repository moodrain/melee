<link href="/lib/element-ui/index.css" rel="stylesheet">
<link href="/lib/mdui/index.css" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        scrollbar-width: none
    }
    html, body, #app {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    a {
        text-decoration: none;
        color: black;
    }
    ::-webkit-scrollbar {
        width: 0;
        height: 0
    }
    .el-tag {
        margin: 2px;
    }
    .mdui-typo table {
        border-collapse: collapse;
        border-spacing: 0;
        empty-cells: show;
        border: 1px solid #cbcbcb;
    }
    .mdui-typo table tbody tr td,th {
        margin: 20px;
        padding: 20px;
        border-width: 0 0 1px 0;
        border-bottom: 1px solid #cbcbcb
    }
    .mdui-typo table thead {
        background-color: #e0e0e0;
        color: #000;
        text-align: left;
        vertical-align: bottom
    }
    .content img {
        max-width: 200px;
        max-height: 200px;
        object-fit: contain;
        cursor: pointer;
    }
    .post {
        margin-top: 50px;
    }
    .post-content {
        overflow: hidden;
        max-height: 200px;
        height: min-content;
    }
    .post-date {
        text-align: right;
        font-size: .9em;
        color: gray
    }
</style>