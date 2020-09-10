if(this.msg) {
    this.$notify({
        message: this.msg,
        type: 'success',
        duration: 5000,
    })
}
if(this.errMsg) {
    this.$notify({
        message: this.errMsg,
        type: 'warning',
        duration: 0,
    })
}
