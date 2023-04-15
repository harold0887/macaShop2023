  <!--Modal add cart-->
  <div class="modal fade" id="adCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title h3 d-flex align-items-center justify-content-center">
                      <i class=" material-icons text-success mr-2">check</i>
                      Agregado al carrito
                  </h4>
                  <button type="button" class="close b-close" data-dismiss="modal" aria-hidden="false">
                      <i class="material-icons">clear</i>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-6 img-product">
                          <img class="w-100" src="{{$img}}" alt="">
                      </div>
                      <div class="col-6 ">
                          <h4> <b>{{$title}}</b> </h4>
                          <h4 class="text-muted">${{$price}}</h4>


                      </div>
                  </div>
              </div>
              <div class="modal-footer ">

                  <div class="row">
                      <div class="col-12 col-md-6">
                          <button type="button" class="btn btn-block  btn-link border h5 mt-2 b-close w-100">Seguir comprando</button>
                      </div>
                      <div class="col-12 col-md-6">
                          <a href="{{ route('cart.index') }}" class="btn btn-block  btn-primary h5 mt-2">
                              Ver carrito y pago
                          </a>

                      </div>
                  </div>
              </div>



          </div>
      </div>
  </div>
  <!-- End Modal add cart-->