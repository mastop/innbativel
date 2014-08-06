<div id="termos" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-combo-">
        <div class="modal-content">
            <div class="modal-header">
                <img src="//{{Configuration::get("s3url")}}/logo.png">
            </div>
            <div class="modal-body">
                <h4>​Termos e Condições de Uso​</h4>​
                {{ Configuration::get('clauses') }}
            </div>
        </div>
    </div>
</div>