<div id="faq" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-stylized">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="entypo circled-help"></span>Perguntas Frequentes</h4>
            </div>
            <div class="modal-body">
                {{ Faq::get() }}
            </div>
        </div>
    </div>
</div>