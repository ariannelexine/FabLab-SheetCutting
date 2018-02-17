<?php
echo '.ui_button:link, .ui_button:visited {
	background-color:#E0E0E0;
	color: black;
	text-align: center;
	text-decoration: none;
	line-height: 250%;
	display: inline-block;
	width: calc(100% - 2px);
	border-style:solid;
	border-width:1px;
	border-color: white;
	margin-bottom: -1px;
}
.ui_button:hover {
	background-color:#C0C0C0;
}
.ui_button:active {
	background-color:#989898;
}
.ui_button_label {
	background-color:#B8B8B8;
	text-align: center;
	line-height: 150%;
	display: inline-block;
	width: calc(100% - 2px);
	border-style:solid;
	border-width:1px;
	border-color: white;
	margin-bottom: -1px;
}
.ui_button_label::selection {
	background-color:transparent;
}

.ui_edit_button:link, .ui_edit_button:visited {
	background-color:#E0E080;
	border-style:solid;
	border-width:1px;
	border-color: #333300;
	color: #333300;
}
.ui_edit_button:hover {
	background-color:#C0C060;
}
.ui_edit_button:active {
	background-color:#989838;
}

.ui_save_button:link, .ui_save_button:visited {
	background-color:#80E080;
	border-style:solid;
	border-width:1px;
	border-color: #003300;
	color: #003300;
}
.ui_save_button:hover {
	background-color:#60C060;
}
.ui_save_button:active {
	background-color:#389838;
}

.ui_close_button:link, .ui_close_button:visited {
	background-color:#E08080;
	border-style:solid;
	border-width:1px;
	border-color: #330000;
	color: #330000;
}
.ui_close_button:hover {
	background-color:#C06060;
}
.ui_close_button:active {
	background-color:#983838;
}
'

?>