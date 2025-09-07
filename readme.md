## **Sistema de Gestão Escolar Laravel** 

**LAVSMS** é desenvolvido para instituições educacionais como escolas e faculdades construído em Laravel 8

**CAPTURAS DE TELA** 

**Dashboard**
<img src="https://i.ibb.co/D4T0z6T/dashboard.png" alt="dashboard" border="0">

**Login**
<img src="https://i.ibb.co/Rh1Bfwk/login.png" alt="login" border="0">

**Boletim do Estudante**
<img src="https://i.ibb.co/GCgv5ZR/marksheet.png" alt="marksheet" border="0">

**Configurações do Sistema**
<img src="https://i.ibb.co/Kmrhw69/system-settings.png" alt="system-settings" border="0">

**Imprimir Boletim**
<div style="clear: both"> </div>
<img src="https://i.ibb.co/5c1GHCj/capture-20210530-115521-crop.png" alt="print-marksheet">

**Imprimir Folha de Tabulação e Boletim**
<img src="https://i.ibb.co/QmscPfn/capture-20210530-115802.png" alt="tabulation-sheet" border="0">

<hr />  

Existem 7 tipos de contas de usuário. Eles incluem:
 
Administradores (Super Admin & Admin)
- Bibliotecário
- Contador
- Professor
- Estudante
- Responsável

**Requisitos** 

Verifique os requisitos do Laravel 8 https://laravel.com/docs/8.x

**Instalação**
- Instalar dependências (composer install)
- Definir credenciais do banco de dados e configurações do app no arquivo dotenv (.env)
- Migrar banco de dados (php artisan migrate)
- Executar seeds do banco (php artisan db:seed)

**Credenciais de Login**
Após executar os seeds. Detalhes de login são os seguintes:

| Tipo de Conta | Nome de Usuário | Email | Senha |
| ------------- | --------------- | ----- | ----- |
| Super Admin | cj | cj@cj.com | cj |
| Admin | admin | admin@admin.com | cj |
| Professor | teacher | teacher@teacher.com | cj |
| Responsável | parent | parent@parent.com | cj |
| Contador | accountant | accountant@accountant.com | cj |
| Estudante | student | student@student.com | cj |

#### **FUNÇÕES DAS CONTAS** 

**-- SUPER ADMIN**
- Apenas o Super Admin pode excluir qualquer registro
- Criar qualquer conta de usuário
 
**-- Administradores (Super Admin & Admin)**

- Gerenciar turmas/seções dos estudantes
- Visualizar boletins dos estudantes
- Criar, editar e gerenciar todas as contas de usuário e perfis
- Criar, editar e gerenciar exames e notas
- Criar, editar e gerenciar matérias
- Gerenciar quadro de avisos da escola
- Avisos são visíveis no calendário do dashboard
- Editar configurações do sistema
- Gerenciar pagamentos e taxas

**-- CONTADOR**
- Gerenciar pagamentos e taxas
- Imprimir recibos de pagamento

**-- BIBLIOTECÁRIO**
- Gerenciar livros na biblioteca

**-- PROFESSOR**
- Gerenciar própria turma/seção
- Gerenciar registros de exames para suas próprias matérias
- Gerenciar horários se designado como professor de turma
- Gerenciar próprio perfil
- Enviar materiais de estudo

**-- ESTUDANTE**
- Visualizar perfil do professor
- Visualizar matérias da própria turma
- Visualizar próprias notas e horários da turma
- Visualizar pagamentos
- Visualizar biblioteca e status dos livros
- Visualizar quadro de avisos e eventos da escola no calendário
- Gerenciar próprio perfil

**-- RESPONSÁVEL**
- Visualizar perfil do professor
- Visualizar boletim do próprio filho (Baixar/Imprimir PDF)
- Visualizar horários do próprio filho
- Visualizar pagamentos do próprio filho
- Visualizar quadro de avisos e eventos da escola no calendário
- Gerenciar próprio perfil

### **Contribuindo**

Suas contribuições e sugestões são bem-vindas.

### **Vulnerabilidades de Segurança**

Se você descobrir uma vulnerabilidade de segurança no LAVSMS, use um pull request. Todas as vulnerabilidades de segurança serão prontamente resolvidas.

***Observação*** algumas seções deste projeto estão em estágio de trabalho em progresso e serão atualizadas em breve. Estas incluem:

- O quadro de avisos/calendário na área do dashboard
- Páginas de usuário bibliotecário/contador
- Recursos da biblioteca/envio de materiais de estudo para estudantes

### **Scripts de Instalação e Deploy**

**Instalação inicial:**
```bash
chmod +x instalar.sh
./instalar.sh
```

**Deploy em produção:**
```bash
chmod +x deploy.sh
./deploy.sh
```

### **Contato [CJ INSPIRED]**
- Telefone : +2347068149559
