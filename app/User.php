<?php

namespace App;

use App\Models\BloodGroup;
use App\Models\Lga;
use App\Models\Nationality;
use App\Models\StaffRecord;
use App\Models\State;
use App\Models\StudentRecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'social_name', 'username', 'email', 'phone', 'phone2', 'phone_mobile', 'phone_home', 
        'dob', 'gender', 'photo', 'address', 'bg_id', 'password', 'nal_id', 'state_id', 'lga_id', 'code', 'user_type', 'email_verified_at',
        'cpf', 'rg', 'rg_issuer', 'rg_state', 'rg_issue_date',
        'cep', 'street', 'number', 'complement', 'neighborhood', 'city', 'uf',
        'birth_certificate', 'vaccination_card', 'sus_card', 'nis'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function student_record()
    {
        return $this->hasOne(StudentRecord::class);
    }

    public function lga()
    {
        return $this->belongsTo(Lga::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nal_id');
    }

    public function blood_group()
    {
        return $this->belongsTo(BloodGroup::class, 'bg_id');
    }

    public function staff()
    {
        return $this->hasMany(StaffRecord::class);
    }

    /**
     * Get formatted CPF
     */
    public function getCpfFormatadoAttribute()
    {
        return \App\Helpers\BrazilianFormat::cpf($this->cpf);
    }

    /**
     * Get formatted CEP
     */
    public function getCepFormatadoAttribute()
    {
        return \App\Helpers\BrazilianFormat::cep($this->cep);
    }

    /**
     * Get formatted mobile phone
     */
    public function getTelefoneCelularFormatadoAttribute()
    {
        return \App\Helpers\BrazilianFormat::phone($this->phone_mobile);
    }

    /**
     * Get formatted home phone
     */
    public function getTelefoneResidencialFormatadoAttribute()
    {
        return \App\Helpers\BrazilianFormat::phone($this->phone_home);
    }

    /**
     * Get complete Brazilian address
     */
    public function getEnderecoCompletoAttribute()
    {
        $endereco = [];
        
        if ($this->street) {
            $endereco[] = $this->street;
        }
        
        if ($this->number) {
            $endereco[] = $this->number;
        }
        
        if ($this->complement) {
            $endereco[] = $this->complement;
        }
        
        if ($this->neighborhood) {
            $endereco[] = $this->neighborhood;
        }
        
        if ($this->city && $this->uf) {
            $endereco[] = $this->city . '/' . $this->uf;
        }
        
        if ($this->cep) {
            $endereco[] = 'CEP: ' . $this->getCepFormatadoAttribute();
        }
        
        return implode(', ', $endereco);
    }

    /**
     * Get display name (social name if available, otherwise regular name)
     */
    public function getNomeExibicaoAttribute()
    {
        return $this->social_name ?: $this->name;
    }
}
