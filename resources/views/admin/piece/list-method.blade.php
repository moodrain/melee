selectChange (selects) { this.selects = selects },
more() { if(this.doMore) { this.doMore() } },
doDelete(id) {
    if(this.selects.length > 0) {
        this.$confirm('确认要删除 ' + this.selects.length + ' 项 {{ $modelName }} ?', '确认', {
            confirmButtonText: '删除',
            cancelButtonText: '取消',
            type: 'warning',
        }).then(() => {
            let ids = []
            this.selects.forEach(e => ids.push(e.id))
            $submit('/admin/{{ $m }}/destroy', {ids})
        }).catch(() => {})
    } else {
        this.$confirm('确认要删除该 {{ $modelName }} ?', '确认', {
            confirmButtonText: '删除',
            cancelButtonText: '取消',
            type: 'warning',
        }).then(() => {
            $submit('/admin/{{ $m }}/destroy', {id})
        }).catch(() => {})
    }
},