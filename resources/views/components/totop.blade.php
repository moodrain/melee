<div style="position: fixed;bottom: 5%;right: 5%;width: 40px;height: 100px">
    <div style="text-align: center">
        <el-button icon="el-icon-top" circle @click="$refs.main.$el.scroll({top: 0, behavior: 'smooth'})"></el-button>
    </div>
    <br />
    <div style="text-align: center">
        <el-button icon="el-icon-bottom" circle @click="$refs.main.$el.scroll({top: 100000, behavior: 'smooth'})"></el-button>
    </div>
</div>