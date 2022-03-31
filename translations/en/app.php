<?php

return [
    'forgot_password_body' => "Hey {{user.fullName|e}},\n\nTo reset your {{siteInfo.siteName}} password, click on this link:\n\n<{{link}}>\n\nIf you were not expecting this email, just ignore it.",
    'forgot_password_heading' => 'When someone forgets their password:',
    'forgot_password_subject' => 'Reset your password',

    'account_activation_body' => "Hey {{user.fullName|e}},\n\nThanks for creating an account with {{siteInfo.siteName}}! To activate your account, click the following link:\n\n<{{link}}>\n\nIf you were not expecting this email, just ignore it.",
    'account_activation_heading' => 'When someone creates an account:',
    'account_activation_subject' => 'Activate your account',

    'verify_new_email_body' => "Hey {{user.fullName|e}},\n\nPlease verify your new email address by clicking on this link:\n\n<{{link}}>\n\nIf you were not expecting this email, just ignore it.",
    'verify_new_email_heading' => 'When someone changes their email address:',
    'verify_new_email_subject' => 'Verify your new email address',
];
