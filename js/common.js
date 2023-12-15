/**
 * 确认是否删除
 * @returns {boolean}
 */
function confirmDelete() {
    return confirm('Êtes-vous sûr de vouloir supprimer cette équipe?');
}


/**
 * 重置表单
 */
function resetForm() {
    // 获取表单
    var form = document.getElementById('searchForm');

    // 清空输入框
    form.querySelector('[name="nom_equipe"]').selectedIndex = 0;
    form.querySelector('[name="role"]').selectedIndex = 0;
}
