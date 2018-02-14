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
'

?>