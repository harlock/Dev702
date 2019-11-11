<div id="update_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="modal-header alert alert-success m-0">
                    <h4 class="modal-title" id="topModalLabel">Editar Post
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="row justify-content-center">
                    <div class="col-10"> <div class="form-group mb-3">
                            <label for="titlePostEdit">Título del post</label>
                            <input type="text" id="titlePostEdit" class="form-control" v-model="editTitle">

                        </div>

                        <div class="form-group mb-3">
                            <label for="descriptionPostEdit">Descripción del post</label>
                            <textarea class="form-control" id="descriptionPostEdit" v-model="editContent"></textarea>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                        data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success" data-dismiss="modal" @click="updatePost">Aceptar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
