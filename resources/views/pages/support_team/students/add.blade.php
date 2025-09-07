@extends('layouts.master')
@section('page_title', 'Matricular Aluno')
@section('content')
        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 class="card-title">Preencha o formulário abaixo para matricular um novo aluno</h6>

                {!! Qs::getPanelOptions() !!}
            </div>

            <form id="ajax-reg" method="post" enctype="multipart/form-data" class="wizard-form steps-validation" action="{{ route('students.store') }}" data-fouc>
               @csrf
                <h6>Dados Pessoais</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome Completo: <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" required type="text" name="name" placeholder="Nome Completo" class="form-control">
                                </div>
                            </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Endereço: <span class="text-danger">*</span></label>
                                <input value="{{ old('address') }}" class="form-control" placeholder="Endereço Completo" name="address" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Endereço de E-mail: </label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Sexo: <span class="text-danger">*</span></label>
                                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Escolha..">
                                    <option value=""></option>
                                    <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Masculino</option>
                                    <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Feminino</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Celular:</label>
                                <input value="{{ old('phone') }}" type="text" name="phone" id="phone" class="form-control" placeholder="(11) 99999-9999" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefone Fixo:</label>
                                <input value="{{ old('phone2') }}" type="text" name="phone2" id="phone2" class="form-control" placeholder="(11) 3333-4444" >
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CPF:</label>
                                <input name="cpf" value="{{ old('cpf') }}" type="text" class="form-control" placeholder="000.000.000-00" maxlength="14" id="cpf">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>RG:</label>
                                <input name="rg" value="{{ old('rg') }}" type="text" class="form-control" placeholder="12.345.678-9" id="rg">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Data de Nascimento:</label>
                                <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="Selecione a data...">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nal_id">Nacionalidade: <span class="text-danger">*</span></label>
                                <select data-placeholder="Escolha..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $nal)
                                        <option {{ (old('nal_id') == $nal->id || $nal->name == 'Brazilian') ? 'selected' : '' }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="state_id">Estado: <span class="text-danger">*</span></label>
                            <select onchange="getLGA(this.value)" required data-placeholder="Escolha.." class="select-search form-control" name="state_id" id="state_id">
                                <option value=""></option>
                                @foreach($states as $st)
                                <option {{ (old('state_id') == $st->id ? 'selected' : '') }} value="{{ $st->id }}" data-uf="{{ $st->uf }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="lga_id">Cidade: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Selecione o Estado primeiro" class="select-search form-control" name="lga_id" id="lga_id">
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bg_id">Tipo Sanguíneo: </label>
                                <select class="select form-control" id="bg_id" name="bg_id" data-fouc data-placeholder="Escolha..">
                                    <option value=""></option>
                                    @foreach(App\Models\BloodGroup::all() as $bg)
                                        <option {{ (old('bg_id') == $bg->id ? 'selected' : '') }} value="{{ $bg->id }}">{{ $bg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Carregar Foto do Aluno:</label>
                                <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                <span class="form-text text-muted">Imagens aceitas: jpeg, png. Tamanho máximo 2MB</span>
                            </div>
                        </div>
                    </div>

                </fieldset>

                <h6>Dados Acadêmicos</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_class_id">Turma: <span class="text-danger">*</span></label>
                                <select onchange="getClassSections(this.value)" data-placeholder="Escolha..." required name="my_class_id" id="my_class_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                </select>
                        </div>
                            </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="section_id">Seção: <span class="text-danger">*</span></label>
                                <select data-placeholder="Selecione a Turma primeiro" required name="section_id" id="section_id" class="select-search form-control">
                                    <option {{ (old('section_id')) ? 'selected' : '' }} value="{{ old('section_id') }}">{{ (old('section_id')) ? 'Selecionado' : '' }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_parent_id">Responsável: </label>
                                <select data-placeholder="Escolha..."  name="my_parent_id" id="my_parent_id" class="select-search form-control">
                                    <option  value=""></option>
                                    @foreach($parents as $p)
                                        <option {{ (old('my_parent_id') == Qs::hash($p->id)) ? 'selected' : '' }} value="{{ Qs::hash($p->id) }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year_admitted">Ano de Matrícula: <span class="text-danger">*</span></label>
                                <select data-placeholder="Escolha..." required name="year_admitted" id="year_admitted" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 10 years')); $y<=date('Y'); $y++)
                                        <option {{ (old('year_admitted') == $y) ? 'selected' : '' }} value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="dorm_id">Dormitório: </label>
                            <select data-placeholder="Escolha..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach($dorms as $d)
                                    <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número do Quarto:</label>
                                <input type="text" name="dorm_room_no" placeholder="Número do Quarto" class="form-control" value="{{ old('dorm_room_no') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Casa Esportiva:</label>
                                <input type="text" name="house" placeholder="Casa Esportiva" class="form-control" value="{{ old('house') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Número de Matrícula:</label>
                                <input type="text" name="adm_no" placeholder="Número de Matrícula" class="form-control" value="{{ old('adm_no') }}">
                            </div>
                        </div>
                    </div>
                </fieldset>

            </form>
        </div>


    @endsection
