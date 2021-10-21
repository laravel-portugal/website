<?php

return [
    'resource' => 'Utilizador',
    'resource_plural' => 'Utilizadores',

    'fields' => [
        'id' => 'ID',
        'name' => 'Nome',
        'email' => 'E-Mail',
        'verification_code' => 'Código',
        'recovery_code' => 'Código de Recuperação',
        'profile_photo_url' => 'Foto de Perfil',
    ],

    'delete-title' => 'Apagar conta',
    'delete-subtitle' => 'Apagar permanentemente a tua conta. Toda a informação será apagada.',
    'delete-warning' => 'Após a tua conta ser apagada toda a informação será apagar ou tornada anónima. Lembra-te que poderás copiar a tua informação antes de o fazeres.',
    'delete-confirmation' => 'Tens a certeza que pretendes apagar a tua conta? Toda a informação será apagada sem possibilidade de recuperação. Para continuar introduz a tua password.',

    'sessions-title' => 'Sessões',
    'sessions-subtitle' => 'Aqui poderás gerir todas as tuas sessões activas em Browsers mobile e Desktop.',
    'sessions-description' => 'Caso a tua conta tenha sido comprometida ou não reconheces alguma das sessões em baixo poderás sempre fazer logout de todas as outras sessões automáticamente, deverás tambem por razões de segurança actualizar a tua password.',
    'sessions-this-device' => 'Este dispositivo',
    'sessions-last-active' => 'Activo à :time',
    'sessions-logout-other' => 'Sair dos outros dispositívos',

    'two-factor-title' => 'Autenticação em 2-Passos',
    'two-factor-subtitle' => 'Reforça o acesso à tua conta uma autenticação em dois passos.',
    'two-factor-on' => 'Autenticação em 2-Passos está activa.',
    'two-factor-on-description' => ' A autenticação em 2-Passos está agora activa, abre a tua Aplicação de autenticação e faz scan ao código QR em baixo.',
    'two-factor-off' => 'Autenticação em 2-Passos está desactivada.',
    'two-factor-description' => 'Quando activada, sempre que efectuares um novo login irá ser pedido um código adicionar de autenticação. Deverás obter este código na aplicação que utilizas-te para fazer o scan. Ex: Google Authenticator/Authy, etc.',

    'two-factor-recovery-codes' => 'Guarda estes códigos no teu gestor de password ou mesmo em um bloco de notas. Caso percas acesso à tua aplicação de autenticação, poderás utilizar este códigos para voltar a entrar.',
    'two-factor-generate' => 'Gerar novos Códigos',
    'two-factor-show-codes' => 'Mostrar Códigos',

    'profile-title' => 'O teu perfil',
    'profile-subtitle' => 'Aqui poderás alterar a tua fotografia de perfil e alterar informações pessoais.',

    'action-upload-photo' => 'Carregar Fotografia',
];
