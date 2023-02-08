<?php
require_once('../init.php');
m_delete_session('m_moderator');
m_redirect(MODERATOR_URL);