<div id="delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content modal-filled bg-danger">
            <div class="modal-body p-4">
                <div class="text-center text-white">
                    <i class="dripicons-wrong h1"></i>
                    <h4 class="mt-2">Eliminar Post</h4>
                    <p class="mt-3">¿Seguro que desea eliminar el post?</p>
                    {{-- en el v-on cambiar el metodo --}}
                    <button type="button" class="btn btn-success my-2" data-dismiss="modal" @click="deletePost">Aceptar</button>
                    <button type="button" class="btn btn-light my-2" data-dismiss="modal" >Cancelar</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>