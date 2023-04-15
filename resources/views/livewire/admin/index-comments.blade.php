<div class="content pt-0">
    @include('includes.spinner-livewire')
    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Comentarios ({{$comments->total()}} registros).</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12">
                            @if ($search != '')
                            <div class="d-flex mt-2">
                                <span class="text-base">Borrar filtros </span>
                                <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearSearch()">close</i>
                            </div>
                            @endif
                        </div>

                        <div class="col-10 col-md-8 pr-0">
                            <form class="form-group">
                                <div class="input-group rounded">
                                    <input id="input-search" type="search" class="form-control px-3" placeholder=" Buscar por nombre, email, producto, etc..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                </div>
                            </form>
                        </div>
                        <div class="col-2 col-lg-1 p-0">
                            <button type="submit" class="btn bg-transparent   btn-round btn-just-icon p-0" style="border:solid 1px #c09aed">
                                <i class="material-icons " style="color:#c09aed">search</i>
                            </button>
                        </div>

                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $comments->count() }} resultados obtenidos</small>

                            @endif
                        </div>

                        @if (isset($comments) && $comments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="cursor:pointer" wire:click="setSort('status')">
                                            @if($sortField=='status')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Aprobado
                                        </th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th style="cursor:pointer" wire:click="setSort('created_at')">
                                            @if($sortField=='created_at')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Fecha
                                        </th>
                                        <th>Producto</th>
                                        <th style="cursor:pointer" wire:click="setSort('best')">
                                            @if($sortField=='best')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Mejores
                                        </th>
                                        <th style="cursor:pointer">Comentario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                    <tr>

                                        <td class="togglebutton" wire:click="changeStatusComments({{ $comment->id }}, '{{ $comment->status }}')">
                                            <label>
                                                <input type="checkbox" {{ $comment->status == 1 ? 'checked ' : '' }} name="status">
                                                <span class="toggle"></span>
                                            </label>
                                        </td>
                                        <td>{{ $comment->user->name }} </td>
                                        <td>{{ $comment->user->email }} </td>
                                        <td>{{date_format($comment->created_at, 'd-M-Y g:i A')}}</td>
                                        <td>{{ $comment->product->title }} </td>

                                        <td class="togglebutton" wire:click="changeStatusBest({{ $comment->id }}, '{{ $comment->best }}')">
                                            <label>
                                                <input type="checkbox" {{ $comment->best == 1 ? 'checked ' : '' }} name="status">
                                                <span class="toggle"></span>
                                            </label>
                                        </td>
                                        <td class="w-25">{{ $comment->comment }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $comments->links() }}
                        </div>
                        @else
                        <div class="col-12">
                            <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>