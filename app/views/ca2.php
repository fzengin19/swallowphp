<link rel="stylesheet" href="css/common-structures.css">
<button id="getInvoices" onclick="openModal('cancelInvoiceModal');">
    Sorgula
</button>

<div id="verifyInvoiceModal" class="cmodal">
    <div class="cmodal-content" id="cancelInvoiceModalContent">
        <div class="cmodal-header">
            <span class="cmodal-header-text">
                Fatura İptal Et
            </span>
            <button onclick="closeModal('verifyInvoiceModal')" class="cmodal-close-btn">&times;</button>
        </div>
        <div class="cmodal-body">
            <div class="cmodal-text">
                Fatura iptal talebi göndermek istediğinizden emin misiniz ?
            </div>
            <div class="row mb-3" style="display: none">
                <div class="col d-flex justify-content-center">
                    <div class="form-check">
                        <i class="fa-light fa-user"></i> <input class="form-check-input" name="remember" type="checkbox" id="remember" checked />
                        <label class="form-check-label" for="remember"> Beni hatırla </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="cmodal-footer">
            <button type="button" onclick="closeModal('verifyInvoiceModal')" class="btn-cancel m-2">İptal</button>
            <button type="button" onclick="verifyInvoice()" class="btn-submit m-2">Sil</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="js/common-structures.js"></script>