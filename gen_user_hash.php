<?php
echo password_hash('user', PASSWORD_BCRYPT, ['cost' => 13]);
