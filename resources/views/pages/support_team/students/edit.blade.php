@extends('layouts.master')
@section('page_title', 'Editar Aluno')
@section('content')

        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 id="ajax-title" class="card-title">Preencha o formulário abaixo para editar o registro de {{ $sr->user->name }}</h6>

                {!! Qs::getPanelOptions() !!}
            </div>

            <form method="post" enctype="multipart/form-data" class="wizard-form steps-validation ajax-update" data-reload="#ajax-title" action="{{ route('students.update', Qs::hash($sr->id)) }}" data-fouc>
                @csrf @method('PUT')
                <h6>Dados Pessoais</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome Completo: <span class="text-danger">*</span></label>
                                <input value="{{ $sr->user->name }}" required type="text" name="name" placeholder="Nome Completo" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Endereço: <span class="text-danger">*</span></label>
                                <input value="{{ $sr->user->address }}" class="form-control" placeholder="Endereço" name="address" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Endereço de E-mail: <span class="text-danger">*</span></label>
                                <input value="{{ $sr->user->email  }}" type="email" name="email" class="form-control" placeholder="seu@email.com">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Sexo: <span class="text-danger">*</span></label>
                                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Escolha..">
                                    <option value=""></option>
                                    <option {{ ($sr->user->gender  == 'Male' ? 'selected' : '') }} value="Male">Masculino</option>
                                    <option {{ ($sr->user->gender  == 'Female' ? 'selected' : '') }} value="Female">Feminino</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefone:</label>
                                <input value="{{ $sr->user->phone  }}" type="text" name="phone" class="form-control" placeholder="(11) 99999-9999" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefone 2:</label>
                                <input value="{{ $sr->user->phone2  }}" type="text" name="phone2" class="form-control" placeholder="(11) 3333-4444" >
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CPF:</label>
                                <input name="cpf" value="{{ $sr->user->cpf }}" type="text" class="form-control" placeholder="000.000.000-00" maxlength="14" id="cpf">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>RG:</label>
                                <input name="rg" value="{{ $sr->user->rg }}" type="text" class="form-control" placeholder="12.345.678-9" id="rg">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Data de Nascimento:</label>
                                <input name="dob" value="{{ $sr->user->dob  }}" type="text" class="form-control date-pick" placeholder="Selecione a data...">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nal_id">Nacionalidade: <span class="text-danger">*</span></label>
                                <select data-placeholder="Escolha..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $na)
                                        <option {{  ($sr->user->nal_id  == $na->id ? 'selected' : '') }} value="{{ $na->id }}">{{ $na->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="state_id">Estado: <span class="text-danger">*</span></label>
                            <select onchange="getLGA(this.value)" required data-placeholder="Escolha.." class="select-search form-control" name="state_id" id="state_id">
                                <option value=""></option>
                                @foreach($states as $st)
                                    <option {{ ($sr->user->state_id  == $st->id ? 'selected' : '') }} value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="lga_id">Cidade: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Selecione o Estado primeiro" class="select-search form-control" name="lga_id" id="lga_id">
                                @if($sr->user->lga_id)
                                    <option selected value="{{ $sr->user->lga_id }}">{{ $sr->user->lga->name}}</option>
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">Tipo Sanguíneo: </label>
                                <select class="select form-control" id="bg_id" name="bg_id" data-fouc data-placeholder="Escolha..">
                                    <option value=""></option>
                                    @foreach(App\Models\BloodGroup::all() as $bg)
                                        <option {{ ($sr->user->bg_id  == $bg->id ? 'selected' : '') }} value="{{ $bg->id }}">{{ $bg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Carregar Foto do Aluno:</label>
                                <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                <span class="form-text text-muted">Imagens aceitas: jpeg, png. Tamanho máximo 2Mb</span>
                            </div>
                        </div>
                    </div>

                </fieldset>

                <h6>Dados Acadêmicos</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_class_id">Turma: </label>
                                <select onchange="getClassSections(this.value)" name="my_class_id" required id="my_class_id" class="form-control select-search" data-placeholder="Selecione a Turma">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ $sr->my_class_id == $c->id ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="section_id">Seção: </label>
                                <select name="section_id" required id="section_id" class="form-control select" data-placeholder="Selecione a Seção">
                                    <option value="{{ $sr->section_id }}">{{ $sr->section->name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_parent_id">Responsável: </label>
                                <select data-placeholder="Escolha..."  name="my_parent_id" id="my_parent_id" class="select-search form-control">
                                    <option  value=""></option>
                                    @foreach($parents as $p)
                                        <option {{ (Qs::hash($sr->parent_id) == Qs::hash($p->id)) ? 'selected' : '' }} value="{{ Qs::hash($p->id) }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year_admitted">Ano de Matrícula: </label>
                                <select name="year_admitted" data-placeholder="Escolha..." id="year_admitted" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 10 years')); $y<=date('Y'); $y++)
                                        <option {{ ($sr->year_admitted == $y) ? 'selected' : '' }} value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="dorm_id">Dormitório: </label>
                            <select data-placeholder="Escolha..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach($dorms as $d)
                                    <option {{ ($sr->dorm_id == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número do Quarto:</label>
                                <input type="text" name="dorm_room_no" placeholder="Número do Quarto" class="form-control" value="{{ $sr->dorm_room_no }}">
                            </div>
                        </div>
                    </div>
                </fieldset>

            </form>
        </div>

        {{-- JavaScript para máscaras de documentos brasileiros --}}
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Máscara CPF
            const cpfInput = document.getElementById('cpf');
            if (cpfInput) {
                cpfInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    e.target.value = value;
                });
            }
            
            // Máscara RG
            const rgInput = document.getElementById('rg');
            if (rgInput) {
                rgInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length <= 9) {
                        value = value.replace(/(\d{2})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    }
                    e.target.value = value;
                });
            }
        });
        </script>
    @endsection
