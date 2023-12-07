<template>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Данные смены</h4>
            <div class="card-options">
                <button class="btn btn-success btn-sm" type="button">Сохранить</button>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group mt-3 mb-3">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-6">Средний чек</div>
                        <div class="col-md-6">
                            <input class="form-control" type="number" min="0">
                        </div>
                    </div>
                </li>
            </ul>
            <button class="btn btn-success" type="button">Сохранить</button>
        </div>

    </div>
</template>

<script>
    export default{
        name: 'WorkshiftVariables',
    }
</script>

<style scoped>

</style>

