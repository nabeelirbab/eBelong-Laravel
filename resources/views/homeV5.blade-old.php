
<html class="no-js" lang="" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title> Home Page Five </title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="icon" href="http://amentotech.com/projects/worketic/" type="image/x-icon">
	<link href="http://amentotech.com/projects/worketic/css/dd.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/app.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/normalize-min.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/scrollbar-min.css" rel="stylesheet">
	<!--<link href="http://amentotech.com/projects/worketic/css/fontawesome/fontawesome-all.min.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/font-awesome.min.css" rel="stylesheet"> -->
	<link href="{{ asset('css/fontawesome/fontawesome-all.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/themify-icons.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/jquery-ui-min.css" rel="stylesheet">
	<!-- <link href="http://amentotech.com/projects/worketic/css/linearicons.css" rel="stylesheet"> -->
	<link href="{{asset('css/linearicons.css') }}" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/owl.carousel.min.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/main.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/custom.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/responsive.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/color.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/maintwo.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/transitions.css" rel="stylesheet">
	<link href="http://amentotech.com/projects/worketic/css/prettyPhoto-min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<style>

@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
 .wt-header .wt-navigation > ul > li > a {
    color: #767676 !important ;
    }
}


	.wt-header .wt-navigation>ul>.menu-item-has-children:after,
	.wt-header .wt-navigation > ul > li > a {
		color: #ffffff;
	}
	
	.wt-navigation > ul > li.current-menu-item > a,
	.wt-navigation ul li .sub-menu > li:hover > a,
	.wt-navigation > ul > li:hover > a {
		color: #fbde44;
	}
	
	.wt-header .wt-navigationarea .wt-navigation > ul > li > a:after {
		background: #fbde44;
	}
	
	.wt-header .wt-navigationarea .wt-userlogedin .wt-username span,
	.wt-header .wt-navigationarea .wt-userlogedin .wt-username h3 {
		color: #ffffff
	}
	
	;
	</style>
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!}
		var readmore_trans = {!! json_encode(trans('lang.read_more')) !!}
		var less_trans = {!! json_encode(trans('lang.less')) !!}
		var Map_key = {!! json_encode(Helper::getGoogleMapApiKey()) !!}
		var APP_DIRECTION = {!! json_encode(Helper::getTextDirection()) !!}
	</script>
	
	<style type="text/css">
	@-webkit-keyframes a {
		0% {
			opacity: 0;
			-webkit-transform: translate3d(-.5em, 0, 0);
			transform: translate3d(-.5em, 0, 0)
		}
		to {
			opacity: 1;
			-webkit-transform: translateZ(0);
			transform: translateZ(0)
		}
	}
	
	@keyframes a {
		0% {
			opacity: 0;
			-webkit-transform: translate3d(-.5em, 0, 0);
			transform: translate3d(-.5em, 0, 0)
		}
		to {
			opacity: 1;
			-webkit-transform: translateZ(0);
			transform: translateZ(0)
		}
	}
	
	@-webkit-keyframes b {
		0% {
			opacity: 0;
			-webkit-transform: translate3d(.5em, 0, 0);
			transform: translate3d(.5em, 0, 0)
		}
		to {
			opacity: 1;
			-webkit-transform: translateZ(0);
			transform: translateZ(0)
		}
	}
	
	@keyframes b {
		0% {
			opacity: 0;
			-webkit-transform: translate3d(.5em, 0, 0);
			transform: translate3d(.5em, 0, 0)
		}
		to {
			opacity: 1;
			-webkit-transform: translateZ(0);
			transform: translateZ(0)
		}
	}
	
	@-webkit-keyframes c {
		0% {
			opacity: 0;
			-webkit-transform: scale(.5);
			transform: scale(.5)
		}
		to {
			opacity: 1;
			-webkit-transform: scale(1);
			transform: scale(1)
		}
	}
	
	@keyframes c {
		0% {
			opacity: 0;
			-webkit-transform: scale(.5);
			transform: scale(.5)
		}
		to {
			opacity: 1;
			-webkit-transform: scale(1);
			transform: scale(1)
		}
	}
	
	@-webkit-keyframes d {
		0% {
			opacity: 0
		}
		to {
			opacity: 1
		}
	}
	
	@keyframes d {
		0% {
			opacity: 0
		}
		to {
			opacity: 1
		}
	}
	
	.vdp-toggle-calendar-enter-active.vdpPositionReady {
		-webkit-transform-origin: top left;
		-ms-transform-origin: top left;
		transform-origin: top left;
		-webkit-animation: c .2s;
		animation: c .2s
	}
	
	.vdp-toggle-calendar-leave-active {
		animation: c .15s reverse
	}
	
	.vdp-toggle-calendar-enter-active.vdpPositionFixed {
		-webkit-animation: d .3s;
		animation: d .3s
	}
	
	.vdp-toggle-calendar-leave-active.vdpPositionFixed {
		animation: d .3s reverse
	}
	
	.vdpComponent {
		position: relative;
		display: inline-block;
		font-size: 10px;
		color: #303030
	}
	
	.vdpComponent.vdpWithInput>input {
		padding-right: 30px
	}
	
	.vdpClearInput {
		font-size: 1em;
		position: absolute;
		top: 0;
		bottom: 0;
		right: 0;
		width: 3em
	}
	
	.vdpClearInput:before {
		content: "\D7";
		width: 1.4em;
		height: 1.4em;
		line-height: 1.1em;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		position: absolute;
		left: 50%;
		top: 50%;
		margin: -.7em 0 0 -.7em;
		color: rgba(0, 0, 0, .3);
		border: 1px solid rgba(0, 0, 0, .15);
		border-radius: 50%;
		background-color: #fff
	}
	
	.vdpClearInput:hover:before {
		-webkit-box-shadow: 0 .2em .5em rgba(0, 0, 0, .15);
		box-shadow: 0 .2em .5em rgba(0, 0, 0, .15)
	}
	
	.vdpOuterWrap.vdpFloating {
		position: absolute;
		padding: .5em 0;
		z-index: 2
	}
	
	.vdpOuterWrap.vdpPositionFixed {
		position: fixed;
		left: 0;
		top: 0;
		bottom: 0;
		right: 0;
		padding: 2em;
		display: -ms-flexbox;
		display: -webkit-box;
		display: flex;
		-ms-flex-pack: center;
		-webkit-box-pack: center;
		justify-content: center;
		-ms-flex-align: center;
		-webkit-box-align: center;
		align-items: center;
		background-color: rgba(0, 0, 0, .3)
	}
	
	.vdpFloating .vdpInnerWrap {
		max-width: 30em
	}
	
	.vdpPositionFixed .vdpInnerWrap {
		max-width: 30em;
		margin: 0 auto;
		border: 0;
		-webkit-animation: c .3s;
		animation: c .3s
	}
	
	.vdpFloating.vdpPositionTop {
		top: 100%
	}
	
	.vdpFloating.vdpPositionBottom {
		bottom: 100%
	}
	
	.vdpFloating.vdpPositionLeft {
		left: 0
	}
	
	.vdpFloating.vdpPositionRight {
		right: 0
	}
	
	.vdpPositionTop.vdpPositionLeft {
		-webkit-transform-origin: top left;
		-ms-transform-origin: top left;
		transform-origin: top left
	}
	
	.vdpPositionTop.vdpPositionRight {
		-webkit-transform-origin: top right;
		-ms-transform-origin: top right;
		transform-origin: top right
	}
	
	.vdpPositionBottom.vdpPositionLeft {
		-webkit-transform-origin: bottom left;
		-ms-transform-origin: bottom left;
		transform-origin: bottom left
	}
	
	.vdpPositionBottom.vdpPositionRight {
		-webkit-transform-origin: bottom right;
		-ms-transform-origin: bottom right;
		transform-origin: bottom right
	}
	
	.vdpInnerWrap {
		overflow: hidden;
		min-width: 28em;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		padding: 1em;
		background: #fff;
		-webkit-box-shadow: 0 .2em 1.5em rgba(0, 0, 0, .06);
		box-shadow: 0 .2em 1.5em rgba(0, 0, 0, .06);
		border-radius: .5em;
		border: 1px solid rgba(0, 0, 0, .15)
	}
	
	.vdpHeader {
		position: relative;
		padding: 0 1em 2.5em;
		margin: -1em -1em -2.5em;
		text-align: center;
		background: #f5f5f5
	}
	
	.vdpArrow,
	.vdpClearInput,
	.vdpPeriodControl>button {
		margin: 0;
		padding: 0;
		border: 0;
		cursor: pointer;
		background: none
	}
	
	.vdpArrow::-moz-focus-inner,
	.vdpClearInput::-moz-focus-inner,
	.vdpPeriodControl>button::-moz-focus-inner {
		padding: 0;
		border: 0
	}
	
	.vdpArrow {
		font-size: 1em;
		width: 5em;
		text-indent: -999em;
		overflow: hidden;
		position: absolute;
		top: 0;
		bottom: 2.5em;
		text-align: left
	}
	
	.vdpArrow:before {
		content: "";
		width: 2.2em;
		height: 2.2em;
		position: absolute;
		left: 50%;
		top: 50%;
		margin: -1.1em 0 0 -1.1em;
		border-radius: 100%;
		-webkit-transition: background-color .2s;
		-o-transition: background-color .2s;
		transition: background-color .2s
	}
	
	.vdpArrow:active,
	.vdpArrow:focus,
	.vdpArrow:hover {
		outline: 0
	}
	
	.vdpArrow:focus:before,
	.vdpArrow:hover:before {
		background-color: rgba(0, 0, 0, .03)
	}
	
	.vdpArrow:active:before {
		background-color: rgba(0, 0, 0, .07)
	}
	
	.vdpArrowNext:before {
		margin-left: -1.4em
	}
	
	.vdpArrow:after {
		content: "";
		position: absolute;
		left: 50%;
		top: 50%;
		margin-top: -.5em;
		width: 0;
		height: 0;
		border: .5em solid transparent
	}
	
	.vdpArrowPrev {
		left: -.3em
	}
	
	.vdpArrowPrev:after {
		margin-left: -.8em;
		border-right-color: #7485c2
	}
	
	.vdpArrowNext {
		right: -.6em
	}
	
	.vdpArrowNext:after {
		margin-left: -.5em;
		border-left-color: #7485c2
	}
	
	.vdpPeriodControl {
		display: inline-block;
		position: relative
	}
	
	.vdpPeriodControl>button {
		font-size: 1.5em;
		padding: 1em .4em;
		display: inline-block
	}
	
	.vdpPeriodControl>select {
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		cursor: pointer;
		opacity: 0;
		font-size: 1.6em
	}
	
	.vdpTable {
		width: 100%;
		table-layout: fixed;
		position: relative;
		z-index: 1
	}
	
	.vdpNextDirection {
		-webkit-animation: b .5s;
		animation: b .5s
	}
	
	.vdpPrevDirection {
		-webkit-animation: a .5s;
		animation: a .5s
	}
	
	.vdpCell,
	.vdpHeadCell {
		text-align: center;
		-webkit-box-sizing: border-box;
		box-sizing: border-box
	}
	
	.vdpCell {
		padding: .5em 0
	}
	
	.vdpHeadCell {
		padding: .3em .5em 1.8em
	}
	
	.vdpHeadCellContent {
		font-size: 1.3em;
		font-weight: 400;
		color: #848484
	}
	
	.vdpCellContent {
		font-size: 1.4em;
		display: block;
		margin: 0 auto;
		width: 1.857em;
		height: 1.857em;
		line-height: 1.857em;
		text-align: center;
		border-radius: 100%;
		-webkit-transition: background .1s, color .1s;
		-o-transition: background .1s, color .1s;
		transition: background .1s, color .1s
	}
	
	.vdpCell.outOfRange {
		color: #c7c7c7
	}
	
	.vdpCell.today {
		color: #7485c2
	}
	
	.vdpCell.selected .vdpCellContent {
		color: #fff;
		background: #7485c2
	}
	
	@media (hover:hover) {
		.vdpCell.selectable:hover .vdpCellContent {
			color: #fff;
			background: #7485c2
		}
	}
	
	.vdpCell.selectable {
		cursor: pointer
	}
	
	.vdpCell.disabled {
		opacity: .5
	}
	
	.vdpTimeControls {
		padding: 1.2em 2em;
		position: relative;
		margin: 1em -1em -1em;
		text-align: center;
		background: #f5f5f5
	}
	
	.vdpTimeUnit {
		display: inline-block;
		position: relative;
		vertical-align: middle
	}
	
	.vdpTimeUnit>input,
	.vdpTimeUnit>pre {
		font-size: 1.7em;
		line-height: 1.3;
		padding: .1em;
		word-wrap: break-word;
		white-space: pre-wrap;
		resize: none;
		margin: 0;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		color: #000;
		border: 0;
		border-bottom: 1px solid transparent;
		text-align: center
	}
	
	.vdpTimeUnit>pre {
		visibility: hidden;
		font-family: inherit
	}
	
	.vdpTimeUnit>input {
		position: absolute;
		top: 0;
		left: 0;
		overflow: hidden;
		height: 100%;
		width: 100%;
		outline: none;
		padding: 0;
		border-radius: 0;
		background: transparent;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none
	}
	
	.vdpTimeUnit>input:focus,
	.vdpTimeUnit>input:hover {
		border-bottom-color: #7485c2
	}
	
	.vdpTimeUnit>input::-webkit-inner-spin-button,
	.vdpTimeUnit>input::-webkit-outer-spin-button {
		margin: 0;
		-webkit-appearance: none
	}
	
	.vdpTimeCaption,
	.vdpTimeSeparator {
		display: inline-block;
		vertical-align: middle;
		font-size: 1.3em;
		color: #848484
	}
	
	.vdpTimeCaption {
		margin-right: .5em
	}
	</style>
	<style type="text/css">
	/*!
 * Datetimepicker for Bootstrap 3
 * version : 4.17.47
 * https://github.com/Eonasdan/bootstrap-datetimepicker/
 */
	
	.bootstrap-datetimepicker-widget {
		list-style: none;
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu {
		display: block;
		margin: 2px 0;
		padding: 4px;
		width: 19em;
	}
	
	@media (min-width: 576px) {
		.bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
			width: 38em;
		}
	}
	
	@media (min-width: 768px) {
		.bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
			width: 38em;
		}
	}
	
	@media (min-width: 992px) {
		.bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
			width: 38em;
		}
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu:before,
	.bootstrap-datetimepicker-widget.dropdown-menu:after {
		content: '';
		display: inline-block;
		position: absolute;
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu.bottom:before {
		border-left: 7px solid transparent;
		border-right: 7px solid transparent;
		border-bottom: 7px solid #ccc;
		border-bottom-color: rgba(0, 0, 0, 0.2);
		top: -7px;
		left: 7px;
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu.bottom:after {
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		border-bottom: 6px solid white;
		top: -6px;
		left: 8px;
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu.top:before {
		border-left: 7px solid transparent;
		border-right: 7px solid transparent;
		border-top: 7px solid #ccc;
		border-top-color: rgba(0, 0, 0, 0.2);
		bottom: -7px;
		left: 6px;
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu.top:after {
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		border-top: 6px solid white;
		bottom: -6px;
		left: 7px;
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu.pull-right:before {
		left: auto;
		right: 6px;
	}
	
	.bootstrap-datetimepicker-widget.dropdown-menu.pull-right:after {
		left: auto;
		right: 7px;
	}
	
	.bootstrap-datetimepicker-widget .list-unstyled {
		margin: 0;
	}
	
	.bootstrap-datetimepicker-widget a[data-action] {
		padding: 6px 0;
	}
	
	.bootstrap-datetimepicker-widget a[data-action]:active {
		box-shadow: none;
	}
	
	.bootstrap-datetimepicker-widget .timepicker-hour,
	.bootstrap-datetimepicker-widget .timepicker-minute,
	.bootstrap-datetimepicker-widget .timepicker-second {
		width: 54px;
		font-weight: bold;
		font-size: 1.2em;
		margin: 0;
	}
	
	.bootstrap-datetimepicker-widget button[data-action] {
		padding: 6px;
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="incrementHours"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Increment Hours";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="incrementMinutes"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Increment Minutes";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="decrementHours"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Decrement Hours";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="decrementMinutes"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Decrement Minutes";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="showHours"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Show Hours";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="showMinutes"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Show Minutes";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="togglePeriod"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Toggle AM/PM";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="clear"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Clear the picker";
	}
	
	.bootstrap-datetimepicker-widget .btn[data-action="today"]::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Set the date to today";
	}
	
	.bootstrap-datetimepicker-widget .picker-switch {
		text-align: center;
	}
	
	.bootstrap-datetimepicker-widget .picker-switch::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Toggle Date and Time Screens";
	}
	
	.bootstrap-datetimepicker-widget .picker-switch td {
		padding: 0;
		margin: 0;
		height: auto;
		width: auto;
		line-height: inherit;
	}
	
	.bootstrap-datetimepicker-widget .picker-switch td span,
	.bootstrap-datetimepicker-widget .picker-switch td i {
		line-height: 2.5;
		height: 2.5em;
		width: 100%;
	}
	
	.bootstrap-datetimepicker-widget table {
		width: 100%;
		margin: 0;
	}
	
	.bootstrap-datetimepicker-widget table td,
	.bootstrap-datetimepicker-widget table th {
		text-align: center;
		border-radius: 0.25rem;
		padding: 0.5em;
	}
	
	.bootstrap-datetimepicker-widget table th {
		height: 20px;
		line-height: 20px;
		width: 20px;
	}
	
	.bootstrap-datetimepicker-widget table th.picker-switch {
		width: 145px;
	}
	
	.bootstrap-datetimepicker-widget table th.disabled,
	.bootstrap-datetimepicker-widget table th.disabled:hover {
		background: none;
		color: #dee2e6;
		cursor: not-allowed;
	}
	
	.bootstrap-datetimepicker-widget table th.prev::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Previous Month";
	}
	
	.bootstrap-datetimepicker-widget table th.next::after {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
		content: "Next Month";
	}
	
	.bootstrap-datetimepicker-widget table thead tr:first-child th {
		cursor: pointer;
	}
	
	.bootstrap-datetimepicker-widget table thead tr:first-child th:hover {
		background: #f8f9fa;
	}
	
	.bootstrap-datetimepicker-widget table td {
		height: 54px;
		line-height: 54px;
		width: 54px;
	}
	
	.bootstrap-datetimepicker-widget table td.cw {
		font-size: .8em;
		height: 20px;
		line-height: 20px;
		color: #dee2e6;
	}
	
	.bootstrap-datetimepicker-widget table td.day {
		height: 20px;
		line-height: 20px;
		width: 20px;
	}
	
	.bootstrap-datetimepicker-widget table td.day:hover,
	.bootstrap-datetimepicker-widget table td.hour:hover,
	.bootstrap-datetimepicker-widget table td.minute:hover,
	.bootstrap-datetimepicker-widget table td.second:hover {
		background: #f8f9fa;
		cursor: pointer;
	}
	
	.bootstrap-datetimepicker-widget table td.old,
	.bootstrap-datetimepicker-widget table td.new {
		color: #dee2e6;
	}
	
	.bootstrap-datetimepicker-widget table td.today {
		position: relative;
	}
	
	.bootstrap-datetimepicker-widget table td.today:before {
		content: '';
		display: inline-block;
		border: solid transparent;
		border-width: 0 0 7px 7px;
		border-bottom-color: #dee2e6;
		border-top-color: rgba(0, 0, 0, 0.2);
		position: absolute;
		bottom: 4px;
		right: 4px;
	}
	
	.bootstrap-datetimepicker-widget table td.active,
	.bootstrap-datetimepicker-widget table td.active:hover {
		background-color: #dee2e6;
		color: #007bff;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	}
	
	.bootstrap-datetimepicker-widget table td.active.today:before {
		border-bottom-color: #fff;
	}
	
	.bootstrap-datetimepicker-widget table td.disabled,
	.bootstrap-datetimepicker-widget table td.disabled:hover {
		background: none;
		color: #dee2e6;
		cursor: not-allowed;
	}
	
	.bootstrap-datetimepicker-widget table td span,
	.bootstrap-datetimepicker-widget table td i {
		display: inline-block;
		width: 54px;
		height: 54px;
		line-height: 54px;
		margin: 2px 1.5px;
		cursor: pointer;
		border-radius: 0.25rem;
	}
	
	.bootstrap-datetimepicker-widget table td span:hover,
	.bootstrap-datetimepicker-widget table td i:hover {
		background: #f8f9fa;
	}
	
	.bootstrap-datetimepicker-widget table td span.active,
	.bootstrap-datetimepicker-widget table td i.active {
		background-color: #dee2e6;
		color: #007bff;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	}
	
	.bootstrap-datetimepicker-widget table td span.old,
	.bootstrap-datetimepicker-widget table td i.old {
		color: #dee2e6;
	}
	
	.bootstrap-datetimepicker-widget table td span.disabled,
	.bootstrap-datetimepicker-widget table td i.disabled,
	.bootstrap-datetimepicker-widget table td span.disabled:hover,
	.bootstrap-datetimepicker-widget table td i.disabled:hover {
		background: none;
		color: #dee2e6;
		cursor: not-allowed;
	}
	
	.bootstrap-datetimepicker-widget.usetwentyfour td.hour {
		height: 27px;
		line-height: 27px;
	}
	
	.bootstrap-datetimepicker-widget.wider {
		width: 21em;
	}
	
	.bootstrap-datetimepicker-widget .datepicker-decades .decade {
		line-height: 1.8em !important;
	}
	
	.input-group.date .input-group-addon {
		cursor: pointer;
	}
	
	.sr-only {
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		border: 0;
	}
	</style>
	<style type="text/css">
	/*
* iziToast | v1.4.0
* http://izitoast.marcelodolce.com
* by Marcelo Dolce.
*/
	
	.iziToast-capsule {
		font-size: 0;
		height: 0;
		width: 100%;
		transform: translateZ(0);
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden;
		transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1), height 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
	}
	
	.iziToast-capsule,
	.iziToast-capsule * {
		box-sizing: border-box;
	}
	
	.iziToast-overlay {
		display: block;
		position: fixed;
		top: -100px;
		left: 0;
		right: 0;
		bottom: -100px;
		z-index: 997;
	}
	
	.iziToast {
		display: inline-block;
		clear: both;
		position: relative;
		font-family: 'Lato', Tahoma, Arial;
		font-size: 14px;
		padding: 8px 45px 9px 0;
		background: rgba(238, 238, 238, 0.9);
		border-color: rgba(238, 238, 238, 0.9);
		width: 100%;
		pointer-events: all;
		cursor: default;
		transform: translateX(0);
		-webkit-touch-callout: none/* iOS Safari */
		;
		-webkit-user-select: none/* Chrome/Safari/Opera */
		;
		-moz-user-select: none/* Firefox */
		;
		-ms-user-select: none/* Internet Explorer/Edge */
		;
		user-select: none;
		min-height: 54px;
	}
	
	.iziToast > .iziToast-progressbar {
		position: absolute;
		left: 0;
		bottom: 0;
		width: 100%;
		z-index: 1;
		background: rgba(255, 255, 255, 0.2);
	}
	
	.iziToast > .iziToast-progressbar > div {
		height: 2px;
		width: 100%;
		background: rgba(0, 0, 0, 0.3);
		border-radius: 0 0 3px 3px;
	}
	
	.iziToast.iziToast-balloon:before {
		content: '';
		position: absolute;
		right: 8px;
		left: auto;
		width: 0px;
		height: 0px;
		top: 100%;
		border-right: 0px solid transparent;
		border-left: 15px solid transparent;
		border-top: 10px solid #000;
		border-top-color: inherit;
		border-radius: 0;
	}
	
	.iziToast.iziToast-balloon .iziToast-progressbar {
		top: 0;
		bottom: auto;
	}
	
	.iziToast.iziToast-balloon > div {
		border-radius: 0 0 0 3px;
	}
	
	.iziToast > .iziToast-cover {
		position: absolute;
		left: 0;
		top: 0;
		bottom: 0;
		height: 100%;
		margin: 0;
		background-size: 100%;
		background-position: 50% 50%;
		background-repeat: no-repeat;
		background-color: rgba(0, 0, 0, 0.1);
	}
	
	.iziToast > .iziToast-close {
		position: absolute;
		right: 0;
		top: 0;
		border: 0;
		padding: 0;
		opacity: 0.6;
		width: 42px;
		height: 100%;
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAJPAAACTwBcGfW0QAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAD3SURBVFiF1ZdtDoMgDEBfdi4PwAX8vLFn0qT7wxantojKupmQmCi8R4tSACpgjC2ICCUbEBa8ingjsU1AXRBeR8aLN64FiknswN8CYefBBDQ3whuFESy7WyQMeC0ipEI0A+0FeBvHUFN8xPaUhAH/iKoWsnXHGegy4J0yxialOfaHJAz4bhRzQzgDvdGnz4GbAonZbCQMuBm1K/kcFu8Mp1N2cFFpsxsMuJqqbIGExGl4loARajU1twskJLLhIsID7+tvUoDnIjTg5T9DPH9EBrz8rxjPzciAl9+O8SxI8CzJ8CxKFfh3ynK8Dyb8wNHM/XDqejx/AtNyPO87tNybAAAAAElFTkSuQmCC") no-repeat 50% 50%;
		background-size: 8px;
		cursor: pointer;
		outline: none;
	}
	
	.iziToast > .iziToast-close:hover {
		opacity: 1;
	}
	
	.iziToast > .iziToast-body {
		position: relative;
		padding: 0 0 0 10px;
		height: auto;
		min-height: 36px;
		margin: 0 0 0 15px;
		text-align: left;
	}
	
	.iziToast > .iziToast-body:after {
		content: "";
		display: table;
		clear: both;
	}
	
	.iziToast > .iziToast-body .iziToast-texts {
		margin: 10px 0 0 0;
		padding-right: 2px;
		display: inline-block;
		float: left;
	}
	
	.iziToast > .iziToast-body .iziToast-inputs {
		min-height: 19px;
		float: left;
		margin: 3px -2px;
	}
	
	.iziToast > .iziToast-body .iziToast-inputs > input:not([type=checkbox]):not([type=radio]),
	.iziToast > .iziToast-body .iziToast-inputs > select {
		position: relative;
		display: inline-block;
		margin: 2px;
		border-radius: 2px;
		border: 0;
		padding: 4px 7px;
		font-size: 13px;
		letter-spacing: 0.02em;
		background: rgba(0, 0, 0, 0.1);
		color: #000;
		box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
		min-height: 26px;
	}
	
	.iziToast > .iziToast-body .iziToast-inputs > input:not([type=checkbox]):not([type=radio]):focus,
	.iziToast > .iziToast-body .iziToast-inputs > select:focus {
		box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.6);
	}
	
	.iziToast > .iziToast-body .iziToast-buttons {
		min-height: 17px;
		float: left;
		margin: 4px -2px;
	}
	
	.iziToast > .iziToast-body .iziToast-buttons > a,
	.iziToast > .iziToast-body .iziToast-buttons > button,
	.iziToast > .iziToast-body .iziToast-buttons > input:not([type=checkbox]):not([type=radio]) {
		position: relative;
		display: inline-block;
		margin: 2px;
		border-radius: 2px;
		border: 0;
		padding: 5px 10px;
		font-size: 12px;
		letter-spacing: 0.02em;
		cursor: pointer;
		background: rgba(0, 0, 0, 0.1);
		color: #000;
	}
	
	.iziToast > .iziToast-body .iziToast-buttons > a:hover,
	.iziToast > .iziToast-body .iziToast-buttons > button:hover,
	.iziToast > .iziToast-body .iziToast-buttons > input:not([type=checkbox]):not([type=radio]):hover {
		background: rgba(0, 0, 0, 0.2);
	}
	
	.iziToast > .iziToast-body .iziToast-buttons > a:focus,
	.iziToast > .iziToast-body .iziToast-buttons > button:focus,
	.iziToast > .iziToast-body .iziToast-buttons > input:not([type=checkbox]):not([type=radio]):focus {
		box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.6);
	}
	
	.iziToast > .iziToast-body .iziToast-buttons > a:active,
	.iziToast > .iziToast-body .iziToast-buttons > button:active,
	.iziToast > .iziToast-body .iziToast-buttons > input:not([type=checkbox]):not([type=radio]):active {
		top: 1px;
	}
	
	.iziToast > .iziToast-body .iziToast-icon {
		height: 100%;
		position: absolute;
		left: 0;
		top: 50%;
		display: table;
		font-size: 23px;
		line-height: 24px;
		margin-top: -12px;
		color: #000;
		width: 24px;
		height: 24px;
	}
	
	.iziToast > .iziToast-body .iziToast-icon.ico-info {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAflBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACCtoPsAAAAKXRSTlMA6PsIvDob+OapavVhWRYPrIry2MxGQ97czsOzpJaMcE0qJQOwVtKjfxCVFeIAAAI3SURBVFjDlJPZsoIwEETnCiGyb8q+qmjl/3/wFmGKwjBROS9QWbtnOqDDGPq4MdMkSc0m7gcDDhF4NRdv8NoL4EcMpzoJglPl/KTDz4WW3IdvXEvxkfIKn7BMZb1bFK4yZFqghZ03jk0nG8N5NBwzx9xU5cxAg8fXi20/hDdC316lcA8o7t16eRuQvW1XGd2d2P8QSHQDDbdIII/9CR3lUF+lbucfJy4WfMS64EJPORnrZxtfc2pjJdnbuags3l04TTtJMXrdTph4Pyg4XAjugAJqMDf5Rf+oXx2/qi4u6nipakIi7CsgiuMSEF9IGKg8heQJKkxIfFSUU/egWSwNrS1fPDtLfon8sZOcYUQml1Qv9a3kfwsEUyJEMgFBKzdV8o3Iw9yAjg1jdLQCV4qbd3no8yD2GugaC3oMbF0NYHCpJYSDhNI5N2DAWB4F4z9Aj/04Cna/x7eVAQ17vRjQZPh+G/kddYv0h49yY4NWNDWMMOMUIRYvlTECmrN8pUAjo5RCMn8KoPmbJ/+Appgnk//Sy90GYBCGgm7IAskQ7D9hFKW4ApB1ei3FSYD9PjGAKygAV+ARFYBH5BsVgG9kkBSAQWKUFYBRZpkUgGVinRWAdUZQDABBQdIcAElDVBUAUUXWHQBZx1gMAGMprM0AsLbVXHsA5trZe93/wp3svQ0YNb/jWV3AIOLsMtlznSNOH7JqjOpDVh7z8qCZR10ftvO4nxeOvPLkpSuvfXnxzKtvXr7j+v8C5ii0e71At7cAAAAASUVORK5CYII=") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast > .iziToast-body .iziToast-icon.ico-warning {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEQAAABECAMAAAAPzWOAAAAAkFBMVEUAAAAAAAABAAIAAAABAAIAAAMAAAABAAIBAAIBAAIAAAIAAAABAAIAAAABAAICAAICAAIAAAIAAAAAAAAAAAABAAIBAAIAAAMAAAABAAIBAAMBAAECAAIAAAIAAAIAAAABAAIBAAIBAAMBAAIBAAEAAAIAAAMAAAAAAAABAAECAAICAAIAAAIAAAMAAAQAAAE05yNAAAAAL3RSTlMAB+kD7V8Q+PXicwv7I9iYhkAzJxnx01IV5cmnk2xmHfzexsK4eEw5L7Gei39aRw640awAAAHQSURBVFjD7ZfJdoJAEEWJgCiI4oDiPM8m7///LidErRO7sHrY5u7YXLr7vKqu9kTC0HPmo9n8cJbEQOzqqAdAUHeUZACQuTkGDQBoDJwkHZR0XBz9FkpafXuHP0SJ09mGeJLZ5wwlTmcbA0THPmdEK7XPGTG1zxmInn3OiJ19zkB0jSVTKExMHT0wjAwlWzC0fSPHF1gWRpIhWMYm7fYTFcQGlbemf4dFfdTGg0B/KXM8qBU/3wntbq7rSGqvJ9kla6IpueFJet8fxfem5yhykjyOgNaWF1qSGd5JMNNxpNF7SZQaVh5JzLrTCZIEJ1GyEyVyd+pClMjdaSJK5O40giSRu5PfFiVyd1pAksjdKRnrSsbVdbiHrgT7yss315fkVQPLFQrL+4FHeOXKO5YRFEKv5AiFaMlKLlBpJuVCJlC5sJfvCgztru/3NmBYccPgGTxRAzxn1XGEMUf58pXZvjoOsOCgjL08+b53mtfAM/SVsZcjKLtysQZPqIy9HPP3m/3zKItRwT0LyQo8sTr26tcO83DIUMWIJjierHLsJda/tbNBFY0BP/bKtcM8HNIWCK3aYR4OMzgxo5w5EFLOLKDExXAm9gI4E3iAO94/Ct/lKWuM2LMGbgAAAABJRU5ErkJggg==") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast > .iziToast-body .iziToast-icon.ico-error {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAeFBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAVyEiIAAAAJ3RSTlMA3BsB98QV8uSyWVUFz7+kcWMM2LuZioBpTUVBNcq2qaibj4d1azLZZYABAAACZElEQVRYw7WX25KCMAyGAxUoFDkpiohnV97/DXeGBtoOUprZ2dyo1K82fxKbwJJVp+KQZ7so2mX5oThVQLKwjDe9YZu4DF3ptAn6rxY0qQPOEq9fNC9ha3y77a22ba24v+9Xbe8v8x03dPOC2/NdvB6xeSreLfGJpnx0TyotKqLm2s7Jd/WO6ivXNp0tCy02R/aFz5VQ5wUPlUL5fIfj5KIlVGU0nWHm/5QtoTVMWY8mzIVu1K9O7XH2JiU/xnOOT39gnUfj+lFHddx4tFjL3/H8jjzaFCy2Rf0c/fdQyQszI8BDR973IyMSKa4krjxAiW/lkRvMP+bKK9WbYS1ASQg8dKjaUGlYPwRe/WoIkz8tiQchH5QAEMv6T0k8MD4mUyWr4E7jAWqZ+xWcMIYkXvlwggJ3IvFK+wIOcpXAo8n8P0COAaXyKH4OsjBuZB4ew0IGu+H1SebhNazsQBbWm8yj+hFuUJB5eMsN0IUXmYendAFFfJB5uEkRMYwxmcd6zDGRtmQePEykAgubymMRFmMxCSIPCRbTuFNN5OGORTjmNGc0Po0m8Uv0gcCry6xUhR2QeLii9tofbEfhz/qvNti+OfPqNm2Mq6105FUMvdT4GPmufMiV8PqBMkc+DdT1bjYYbjzU/ew23VP4n3mLAz4n8Jtv/Ui3ceTT2mzz5o1mZt0gnBpmsdjqRqVlmplcPdqa7X23kL9brdm2t/uBYDPn2+tyu48mtIGD10JTuUrukVrbCFiwDzcHrPjxKt7PW+AZQyT/WESO+1WL7f3o+WLHL2dYMSZsg6dg/z360ofvP4//v1NPzgs28WlWAAAAAElFTkSuQmCC") no-repeat 50% 50%;
		background-size: 80%;
	}
	
	.iziToast > .iziToast-body .iziToast-icon.ico-success {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABABAMAAABYR2ztAAAAIVBMVEUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABt0UjBAAAACnRSTlMApAPhIFn82wgGv8mVtwAAAKVJREFUSMft0LEJAkEARNFFFEw1NFJb8CKjAy1AEOzAxNw+bEEEg6nyFjbY4LOzcBwX7S/gwUxoTdIn+Jbv4Lv8bx446+kB6VsBtK0B+wbMCKxrwL33wOrVeeChX28n7KTOTjgoEu6DRSYAgAAAAkAmAIAAAAIACQIkMkACAAgAIACAyECBKAOJuCagTJwSUCaUAEMAABEBRwAAEQFLbCJgO4bW+AZKGnktR+jAFAAAAABJRU5ErkJggg==") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast > .iziToast-body .iziToast-icon.ico-question {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAQAAAAAYLlVAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfhCQkUEhFovxTxAAAEDklEQVRo3s2ZTWgTQRTHf03ipTRUqghNSgsRjHgQrFUQC6JgD1Kak3gQUUoPqRdBglf1oBehBws9Cn4cGk+1SOmh2upBxAYVoeJHrR9tgq0i1Cq0lqYeks7MbpPdmU00/c8hm9n33v/t7Nt5M2+qMEWQI0QIibZKRrQpHvLL2KI2wnQzzBKrDm2RIeKEy01dTYKUI7G1ZRknQXV5yP10kTYgly1NF/5S6duZ8ES+1iZodyaocrjXxE0OFeifYYgp0mRIkwFChAkRJsIxGgrIP+I0n82fvZW5dc/zkss0O2o1c5mX6/TmaDWl77RFe5YkUW3tKEmyFv0lOvXJ/fTYnmCEFuMRbGHEZqVHLyT9DFjUJmkzJl9DG5MWWwM6Llif/gF1nukB6nhgGwUXdFrE+wiURA8QoM9i0zEWWpXQW+ZsyeRrOMuyEo5Fv4gmy4dXPvqcC+pH2VRYaMwy+OWG+iLGCgm0W0Kv9HdvR8ASjmKCXpuK/bxiV/76A/v5UdDIZuKcJGjrnec5KZ7wwsWFOp6xPX/9mt2sqDe7FO+Kf/fXHBPPDWpdXGhTpLvUG9VKwh1xMDDjkvu+cNDFBTk7ptX1QkKZ850m3duu6fcrWxwdaFFyREJ2j4vOpKP6Du6z4uJCv8sYJIVkCnJBGGZaBONO3roY2EqNrSfIPi7SKP4fdXyNUd6I6wbSAHEl33tFLe+FlSsusnK90A0+oEPcuufZgXnOi+u9LrKSJQZQw6LwqBnv2CKsfHORbFbyQhA6xN/pEuihSdj56Co7LWRjPiKie6gkB2LiKuUqK5kiPkLiz1QJ9K1cNXBAMoUCigNpQ9IqDtMI1HKA4/jyvUsaoSyZLA5kjOjDPFZen8Ql5TsvBskUgjciIPSX3QAXC86DT7VWvlEh/xZ+ij9BDVWJ0QL0SbZq6QaFxoLPcXPmBLveLCc4wXdDK6s+6/vwhCSniFLPXW0NJe5UB8zKCsviqpc7vGPVQFcyZbyPwGD+d5ZnxmNWlhG4xSBZZjivjIWHEQgoDkSMjMwTo54569JSE5IpA7EyJSMTyGTUAUFlO1ZKOtaHTMeL1PhYYFTcihmY2cQ5+ullj7EDkiVfVez2sCTz8yiv84djhg7IJVk81xFWJlPdfHBG0flkRC/zQFZ+DSllNtfDdUsOMCliyGX5uOzU3ZhIXFDof4m1gDuKbEx0t2YS25gVGpcMnr/I1kx3c6piB8P8ZoqEwfMX3ZyCXynJTmq/U7NUXqfUzCbWL1wqVKBQUeESzQYoUlW8TAcVL1RCxUu1G6BYXfFyfQ4VPbDI4T8d2WzgQ6sc/vmxnTsqfHCZQzUJxm1h5dxS5Tu6lQgTZ0ipqRVqSwzTbbLHMt+c19iO76tsx/cLZub+Ali+tYC93olEAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE3LTA5LTA5VDIwOjE4OjE3KzAyOjAwjKtfjgAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxNy0wOS0wOVQyMDoxODoxNyswMjowMP325zIAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast > .iziToast-body .iziToast-title {
		padding: 0;
		margin: 0;
		line-height: 16px;
		font-size: 14px;
		text-align: left;
		float: left;
		color: #000;
		white-space: normal;
	}
	
	.iziToast > .iziToast-body .iziToast-message {
		padding: 0;
		margin: 0 0 10px 0;
		font-size: 14px;
		line-height: 16px;
		text-align: left;
		float: left;
		color: rgba(0, 0, 0, 0.6);
		white-space: normal;
	}
	
	.iziToast.iziToast-animateInside .iziToast-title,
	.iziToast.iziToast-animateInside .iziToast-message,
	.iziToast.iziToast-animateInside .iziToast-icon,
	.iziToast.iziToast-animateInside .iziToast-buttons-child,
	.iziToast.iziToast-animateInside .iziToast-inputs-child {
		opacity: 0;
	}
	
	.iziToast-target {
		position: relative;
		width: 100%;
		margin: 0 auto;
	}
	
	.iziToast-target .iziToast-capsule {
		overflow: hidden;
	}
	
	.iziToast-target .iziToast-capsule:after {
		visibility: hidden;
		display: block;
		font-size: 0;
		content: " ";
		clear: both;
		height: 0;
	}
	
	.iziToast-target .iziToast-capsule .iziToast {
		width: 100%;
		float: left;
	}
	
	.iziToast-wrapper {
		z-index: 99999;
		position: fixed;
		width: 100%;
		pointer-events: none;
		display: flex;
		flex-direction: column;
	}
	
	.iziToast-wrapper .iziToast.iziToast-balloon:before {
		border-right: 0 solid transparent;
		border-left: 15px solid transparent;
		border-top: 10px solid #000;
		border-top-color: inherit;
		right: 8px;
		left: auto;
	}
	
	.iziToast-wrapper-bottomLeft {
		left: 0;
		bottom: 0;
		text-align: left;
	}
	
	.iziToast-wrapper-bottomLeft .iziToast.iziToast-balloon:before {
		border-right: 15px solid transparent;
		border-left: 0 solid transparent;
		right: auto;
		left: 8px;
	}
	
	.iziToast-wrapper-bottomRight {
		right: 0;
		bottom: 0;
		text-align: right;
	}
	
	.iziToast-wrapper-topLeft {
		left: 0;
		top: 0;
		text-align: left;
	}
	
	.iziToast-wrapper-topLeft .iziToast.iziToast-balloon:before {
		border-right: 15px solid transparent;
		border-left: 0 solid transparent;
		right: auto;
		left: 8px;
	}
	
	.iziToast-wrapper-topRight {
		top: 0;
		right: 0;
		text-align: right;
	}
	
	.iziToast-wrapper-topCenter {
		top: 0;
		left: 0;
		right: 0;
		text-align: center;
	}
	
	.iziToast-wrapper-bottomCenter {
		bottom: 0;
		left: 0;
		right: 0;
		text-align: center;
	}
	
	.iziToast-wrapper-center {
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		text-align: center;
		justify-content: center;
		flex-flow: column;
		align-items: center;
	}
	
	.iziToast-rtl {
		direction: rtl;
		padding: 8px 0 9px 45px;
		font-family: Tahoma, 'Lato', Arial;
	}
	
	.iziToast-rtl .iziToast-cover {
		left: auto;
		right: 0;
	}
	
	.iziToast-rtl .iziToast-close {
		right: auto;
		left: 0;
	}
	
	.iziToast-rtl .iziToast-body {
		padding: 0 10px 0 0;
		margin: 0 16px 0 0;
		text-align: right;
	}
	
	.iziToast-rtl .iziToast-body .iziToast-buttons,
	.iziToast-rtl .iziToast-body .iziToast-inputs,
	.iziToast-rtl .iziToast-body .iziToast-texts,
	.iziToast-rtl .iziToast-body .iziToast-title,
	.iziToast-rtl .iziToast-body .iziToast-message {
		float: right;
		text-align: right;
	}
	
	.iziToast-rtl .iziToast-body .iziToast-icon {
		left: auto;
		right: 0;
	}
	
	@media only screen and (min-width: 568px) {
		.iziToast-wrapper {
			padding: 10px 15px;
		}
		.iziToast {
			margin: 5px 0;
			border-radius: 3px;
			width: auto;
		}
		.iziToast:after {
			content: '';
			z-index: -1;
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			border-radius: 3px;
			box-shadow: inset 0 -10px 20px -10px rgba(0, 0, 0, 0.2), inset 0 0 5px rgba(0, 0, 0, 0.1), 0 8px 8px -5px rgba(0, 0, 0, 0.25);
		}
		.iziToast:not(.iziToast-rtl) .iziToast-cover {
			border-radius: 3px 0 0 3px;
		}
		.iziToast.iziToast-rtl .iziToast-cover {
			border-radius: 0 3px 3px 0;
		}
		.iziToast.iziToast-color-dark:after {
			box-shadow: inset 0 -10px 20px -10px rgba(255, 255, 255, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.25);
		}
		.iziToast.iziToast-balloon .iziToast-progressbar {
			background: transparent;
		}
		.iziToast.iziToast-balloon:after {
			box-shadow: 0 10px 10px -5px rgba(0, 0, 0, 0.25), inset 0 10px 20px -5px rgba(0, 0, 0, 0.25);
		}
		.iziToast-target .iziToast:after {
			box-shadow: inset 0 -10px 20px -10px rgba(0, 0, 0, 0.2), inset 0 0 5px rgba(0, 0, 0, 0.1);
		}
	}
	
	.iziToast.iziToast-theme-dark {
		background: #565c70;
		border-color: #565c70;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-title {
		color: #fff;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-message {
		color: rgba(255, 255, 255, 0.7);
		font-weight: 300;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-close {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAQAAADZc7J/AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfgCR4OIQIPSao6AAAAwElEQVRIx72VUQ6EIAwFmz2XB+AConhjzqTJ7JeGKhLYlyx/BGdoBVpjIpMJNjgIZDKTkQHYmYfwmR2AfAqGFBcO2QjXZCd24bEggvd1KBx+xlwoDpYmvnBUUy68DYXD77ESr8WDtYqvxRex7a8oHP4Wo1Mkt5I68Mc+qYqv1h5OsZmZsQ3gj/02h6cO/KEYx29hu3R+VTTwz6D3TymIP1E8RvEiiVdZfEzicxYLiljSxKIqlnW5seitTW6uYnv/Aqh4whX3mEUrAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE2LTA5LTMwVDE0OjMzOjAyKzAyOjAwl6RMVgAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxNi0wOS0zMFQxNDozMzowMiswMjowMOb59OoAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC") no-repeat 50% 50%;
		background-size: 8px;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-icon {
		color: #fff;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-icon.ico-info {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAflBMVEUAAAD////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////vroaSAAAAKXRSTlMA6PsIvDob+OapavVhWRYPrIry2MxGQ97czsOzpJaMcE0qJQOwVtKjfxCVFeIAAAI3SURBVFjDlJPZsoIwEETnCiGyb8q+qmjl/3/wFmGKwjBROS9QWbtnOqDDGPq4MdMkSc0m7gcDDhF4NRdv8NoL4EcMpzoJglPl/KTDz4WW3IdvXEvxkfIKn7BMZb1bFK4yZFqghZ03jk0nG8N5NBwzx9xU5cxAg8fXi20/hDdC316lcA8o7t16eRuQvW1XGd2d2P8QSHQDDbdIII/9CR3lUF+lbucfJy4WfMS64EJPORnrZxtfc2pjJdnbuags3l04TTtJMXrdTph4Pyg4XAjugAJqMDf5Rf+oXx2/qi4u6nipakIi7CsgiuMSEF9IGKg8heQJKkxIfFSUU/egWSwNrS1fPDtLfon8sZOcYUQml1Qv9a3kfwsEUyJEMgFBKzdV8o3Iw9yAjg1jdLQCV4qbd3no8yD2GugaC3oMbF0NYHCpJYSDhNI5N2DAWB4F4z9Aj/04Cna/x7eVAQ17vRjQZPh+G/kddYv0h49yY4NWNDWMMOMUIRYvlTECmrN8pUAjo5RCMn8KoPmbJ/+Appgnk//Sy90GYBCGgm7IAskQ7D9hFKW4ApB1ei3FSYD9PjGAKygAV+ARFYBH5BsVgG9kkBSAQWKUFYBRZpkUgGVinRWAdUZQDABBQdIcAElDVBUAUUXWHQBZx1gMAGMprM0AsLbVXHsA5trZe93/wp3svQ0YNb/jWV3AIOLsMtlznSNOH7JqjOpDVh7z8qCZR10ftvO4nxeOvPLkpSuvfXnxzKtvXr7j+v8C5ii0e71At7cAAAAASUVORK5CYII=") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-icon.ico-warning {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEQAAABECAMAAAAPzWOAAAAAllBMVEUAAAD////+//3+//3+//3///////z+//3+//3+//3////////////9//3////+//39//3///3////////////+//3+//39//3///z+//z+//7///3///3///3///3////////+//3+//3+//3+//z+//3+//7///3///z////////+//79//3///3///z///v+//3///+trXouAAAAMHRSTlMAB+j87RBf+PXiCwQClSPYhkAzJxnx05tSyadzcmxmHRbp5d7Gwrh4TDkvsYt/WkdQzCITAAAB1UlEQVRYw+3XaXKCQBCGYSIIighoxCVqNJrEPfly/8vFImKXduNsf/Mc4K1y7FnwlMLQc/bUbj85R6bA1LXRDICg6RjJcZa7NQYtnLUGTpERSiOXxrOPkv9s30iGKDmtbYir3H7OUHJa2ylAuvZzRvzUfs7Ii/2cgfTt54x82s8ZSM848gJmYtroQzA2jHwA+LkBIEuMGt+QIng1igzlyMrkuP2CyOi47axRaYTL5jhDJehoR+aovC29s3iIyly3Eb+hRCvZo2qsGTnhKr2cLDS+J73GsqBI9W80UCmWWpEuhIjh6ZRGjyNRarjzKGJ2Ou2himCvjHwqI+rTqQdlRH06TZQR9ek0hiqiPp06mV4ke7QPX6ERUZxO8Uo3sqrfhxvoRrCpvXwL/UjR9GRHMIvLgke4d5QbiwhM6JV2YKKF4vIl7XIBkwm4keryJVmvk/TfwcmPwQNkUQuyA2/sYGwnXL7GPu4bW1jYsmevrNj09/MGZMOEPXslQVqO8hqykD17JfPHP/bmo2yGGpdZiH3IZvzZa7B3+IdDjjpjesHJcvbs5dZ/e+cddVoDdvlq7x12Nac+iN7e4R8OXTjp0pw5CGnOLNDEzeBs5gVwFniAO+8f8wvfeXP2hyqnmwAAAABJRU5ErkJggg==") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-icon.ico-error {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAeFBMVEUAAAD////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////GqOSsAAAAJ3RSTlMA3BsB98QV8uSyWVUFz6RxYwzYvbupmYqAaU1FQTXKv7abj4d1azKNUit3AAACZElEQVRYw7WXaZOCMAyGw30UORRQBLxX/v8/3BkaWjrY2szO5otKfGrzJrEp6Kw6F8f8sI+i/SE/FucKSBaWiT8p5idlaEtnXTB9tKDLLHAvdSatOan3je93k9F2vRF36+mr1a6eH2NFNydoHq/ieU/UXcWjjk9XykdNWq2ywtp4tXL6Wb2T/MqtzzZutsrNyfvA51KoQROhVCjfrnASIRpSVUZiD5v4RbWExjRdJzSmOsZFvzYz59kRSr6V5zE+/QELHkNdb3VRx45HS1b1u+zfkkcbRAZ3qJ9l/A4qefHUDMShJe+6kZKJDD2pLQ9Q4lu+5Q7rz7Plperd7AtQEgIPI6o2dxr2D4GXvxqCiKcn8cD4gxIAEt7/GYkHL16KqeJd0NB4gJbXfgVnzCGJlzGcocCVSLzUvoAj9xJ4NF7/R8gxoVQexc/hgBpSebjPjgPs59cHmYfn7NkDb6wXmUf1I1ygIPPw4gtgCE8yDw8eAop4J/PQcBExjQmZx37MsZB2ZB4cLKQCG5vKYxMWSzMxIg8pNtOyUkvkocEmXGo69mh8FgnxS4yBwMvDrJSNHZB4uC3ayz/YkcIP4lflwVIT+OU07ZSjrbTkZQ6dTPkYubZ8GC/Cqxu6WvJZII93dcCw46GdNqdpTeF/tiMOuDGB9z/NI6NvyWetGPM0g+bVNeovBmamHXWj0nCbEaGeTMN2PWrqd6cM26ZxP2DeJvj+ph/30Zi/GmRbtlK5SptI+nwGGnvH6gUruT+L16MJHF+58rwNIifTV0vM8+hwMeOXAb6Yx0wXT+b999WXfvn+8/X/F7fWzjdTord5AAAAAElFTkSuQmCC") no-repeat 50% 50%;
		background-size: 80%;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-icon.ico-success {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABABAMAAABYR2ztAAAAIVBMVEUAAAD////////////////////////////////////////PIev5AAAACnRSTlMApAPhIFn82wgGv8mVtwAAAKVJREFUSMft0LEJAkEARNFFFEw1NFJb8CKjAy1AEOzAxNw+bEEEg6nyFjbY4LOzcBwX7S/gwUxoTdIn+Jbv4Lv8bx446+kB6VsBtK0B+wbMCKxrwL33wOrVeeChX28n7KTOTjgoEu6DRSYAgAAAAkAmAIAAAAIACQIkMkACAAgAIACAyECBKAOJuCagTJwSUCaUAEMAABEBRwAAEQFLbCJgO4bW+AZKGnktR+jAFAAAAABJRU5ErkJggg==") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-icon.ico-question {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAQAAAAAYLlVAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfhCQkUEg18vki+AAAETUlEQVRo3s1ZTWhbRxD+VlIuxsLFCYVIIQYVopBDoK5bKDWUBupDMNbJ5FBKg/FBziUQdE9yaC+FHBrwsdCfQ9RTGoLxwWl+DqHEojUFFydxnB9bInZDqOsErBrr6yGvs/ueX97bldTKo4Pe7puZb3Z33s7srIIjMY1jyCEjP6ImvyX8pF64arSHznKC06wzijY5xSKz7YbuYokV2lODsyyxqz3gSY6z6gCuqcpxJluFH+Z8U+D/0jyHoxFUBHgfvsGHIS9WMIUlVFFDFTUAGWSRQRY5HMeBEP6b+Ew9dh/7INd2jGeO59kfKdXP85zbIbfGQVf4sYC3N1hm3lo6zzIbPvk6x+zBk7wQGMEMB5xncIAzAS0XrFySSV72iS1yyBVcdA1x0afrsoUJgdFfY2+z8ADAXl7zz0KcwJiPfZKpVuABgClO+nRG+QIHDdfb4qlWwUXvKW4Z7vi6L4J9vg+vbfCeCeZH2RfOdMOc/HbCA4BvIW6EMQz7XK/ltd+hP+VzR9mgva2YSfyGI17fA7ynnocqeQNFfIJ0oHsdv6CC2+rXGBN6cQdveY3fcVRtmy/HDete+93zy8jA8zV7YkwYMrjHzRddRsCdiVCwwmh6wg9iTNC7Y9XIF1iS7kbUpsvvGEdPuTfSgAEjRpR096x0liPFD/Eqt2NMuBQzB2XhrACAApjFsuQFh9XdGAX70B3oSuNdnMVBaX+sopYxjwVpHFBVACyKTXNoktjD+6Ll8xhenS9MAAkAI/Lux2YNUOs4I413Ypg1SgEAu7kpFvWjaeJe0fJHDGe/cNaZBkekudw8PMA+0fMwlndZeAsJ5KR/qhUDUJCnSiyvRsolkJHGUgvjH8QXDgZopEzKMKDqCKrwEQ4C6MH7GEXC665buLJG8hlQc4LP4paxfJrOqYVYYY2UARfEIazTbgDg2dB98GebzJd54b8L/iWNdLyooeR6CHyZ+6xk0yKxkYg6nEVSUG4VJ9QJ9cxRCxO+9WiOyvgUeexXP1hLGH5nGuBWVtiSp4vqe3VP0UFWI9Wan4Er3v8q7jjPWVtm4FtcQQMrOKO2nOQCM5AyDMi56FDrKHA/1nyppS1ppBpYaE8wciEjGI2AaeM41kI4doDX4XiT3Qm1gevyruCgZg9P8xIv8m1nCzTKq6oiJ9xTMiZ505P5m8cdZ0CnZMVXHVljM7WMBzxpyDxygtdxoCEFTaMIWbZU85UvBjgUMYy0fBaAF8V1Lj9qWQ1aMZ5f4k9r+AGMSkMP1vZoZih6k6sicc5h/OFHM9vDqU/VIU7zJZdYYsKGH4g4nAJMGiXZRds1pVMoZ69RM5vfkbh0qkBhsnS2RLMLilQdL9MBHS9UAh0v1e6CYnXHy/WeeCcvLDwl/9OVze69tPKM+M+v7eJN6OzFpWdEF0ucDbhVNFXadnVrmJFlkVNGTS2M6pzmhMvltfPhnN2B63sVuL7fcNP3D1TSk2ihosPrAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE3LTA5LTA5VDIwOjE4OjEzKzAyOjAweOR7nQAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxNy0wOS0wOVQyMDoxODoxMyswMjowMAm5wyEAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC") no-repeat 50% 50%;
		background-size: 85%;
	}
	
	.iziToast.iziToast-theme-dark .iziToast-buttons > a,
	.iziToast.iziToast-theme-dark .iziToast-buttons > button,
	.iziToast.iziToast-theme-dark .iziToast-buttons > input {
		color: #fff;
		background: rgba(255, 255, 255, 0.1);
	}
	
	.iziToast.iziToast-theme-dark .iziToast-buttons > a:hover,
	.iziToast.iziToast-theme-dark .iziToast-buttons > button:hover,
	.iziToast.iziToast-theme-dark .iziToast-buttons > input:hover {
		background: rgba(255, 255, 255, 0.2);
	}
	
	.iziToast.iziToast-theme-dark .iziToast-buttons > a:focus,
	.iziToast.iziToast-theme-dark .iziToast-buttons > button:focus,
	.iziToast.iziToast-theme-dark .iziToast-buttons > input:focus {
		box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.6);
	}
	
	.iziToast.iziToast-color-red {
		background: rgba(255, 175, 180, 0.9);
		border-color: rgba(255, 175, 180, 0.9);
	}
	
	.iziToast.iziToast-color-orange {
		background: rgba(255, 207, 165, 0.9);
		border-color: rgba(255, 207, 165, 0.9);
	}
	
	.iziToast.iziToast-color-yellow {
		background: rgba(255, 249, 178, 0.9);
		border-color: rgba(255, 249, 178, 0.9);
	}
	
	.iziToast.iziToast-color-blue {
		background: rgba(157, 222, 255, 0.9);
		border-color: rgba(157, 222, 255, 0.9);
	}
	
	.iziToast.iziToast-color-green {
		background: rgba(166, 239, 184, 0.9);
		border-color: rgba(166, 239, 184, 0.9);
	}
	
	.iziToast.iziToast-layout2 .iziToast-body .iziToast-texts,
	.iziToast.iziToast-layout2 .iziToast-body .iziToast-message {
		width: 100%;
	}
	
	.iziToast.iziToast-layout3 {
		border-radius: 2px;
	}
	
	.iziToast.iziToast-layout3::after {
		display: none;
	}
	
	.iziToast.revealIn,
	.iziToast .revealIn {
		-webkit-animation: iziT-revealIn 1s cubic-bezier(0.25, 1.6, 0.25, 1) both;
		animation: iziT-revealIn 1s cubic-bezier(0.25, 1.6, 0.25, 1) both;
	}
	
	.iziToast.slideIn,
	.iziToast .slideIn {
		-webkit-animation: iziT-slideIn 1s cubic-bezier(0.16, 0.81, 0.32, 1) both;
		animation: iziT-slideIn 1s cubic-bezier(0.16, 0.81, 0.32, 1) both;
	}
	
	.iziToast.bounceInLeft {
		-webkit-animation: iziT-bounceInLeft 0.7s ease-in-out both;
		animation: iziT-bounceInLeft 0.7s ease-in-out both;
	}
	
	.iziToast.bounceInRight {
		-webkit-animation: iziT-bounceInRight 0.85s ease-in-out both;
		animation: iziT-bounceInRight 0.85s ease-in-out both;
	}
	
	.iziToast.bounceInDown {
		-webkit-animation: iziT-bounceInDown 0.7s ease-in-out both;
		animation: iziT-bounceInDown 0.7s ease-in-out both;
	}
	
	.iziToast.bounceInUp {
		-webkit-animation: iziT-bounceInUp 0.7s ease-in-out both;
		animation: iziT-bounceInUp 0.7s ease-in-out both;
	}
	
	.iziToast.fadeIn,
	.iziToast .fadeIn {
		-webkit-animation: iziT-fadeIn 0.5s ease both;
		animation: iziT-fadeIn 0.5s ease both;
	}
	
	.iziToast.fadeInUp {
		-webkit-animation: iziT-fadeInUp 0.7s ease both;
		animation: iziT-fadeInUp 0.7s ease both;
	}
	
	.iziToast.fadeInDown {
		-webkit-animation: iziT-fadeInDown 0.7s ease both;
		animation: iziT-fadeInDown 0.7s ease both;
	}
	
	.iziToast.fadeInLeft {
		-webkit-animation: iziT-fadeInLeft 0.85s cubic-bezier(0.25, 0.8, 0.25, 1) both;
		animation: iziT-fadeInLeft 0.85s cubic-bezier(0.25, 0.8, 0.25, 1) both;
	}
	
	.iziToast.fadeInRight {
		-webkit-animation: iziT-fadeInRight 0.85s cubic-bezier(0.25, 0.8, 0.25, 1) both;
		animation: iziT-fadeInRight 0.85s cubic-bezier(0.25, 0.8, 0.25, 1) both;
	}
	
	.iziToast.flipInX {
		-webkit-animation: iziT-flipInX 0.85s cubic-bezier(0.35, 0, 0.25, 1) both;
		animation: iziT-flipInX 0.85s cubic-bezier(0.35, 0, 0.25, 1) both;
	}
	
	.iziToast.fadeOut {
		-webkit-animation: iziT-fadeOut 0.7s ease both;
		animation: iziT-fadeOut 0.7s ease both;
	}
	
	.iziToast.fadeOutDown {
		-webkit-animation: iziT-fadeOutDown 0.7s cubic-bezier(0.4, 0.45, 0.15, 0.91) both;
		animation: iziT-fadeOutDown 0.7s cubic-bezier(0.4, 0.45, 0.15, 0.91) both;
	}
	
	.iziToast.fadeOutUp {
		-webkit-animation: iziT-fadeOutUp 0.7s cubic-bezier(0.4, 0.45, 0.15, 0.91) both;
		animation: iziT-fadeOutUp 0.7s cubic-bezier(0.4, 0.45, 0.15, 0.91) both;
	}
	
	.iziToast.fadeOutLeft {
		-webkit-animation: iziT-fadeOutLeft 0.5s ease both;
		animation: iziT-fadeOutLeft 0.5s ease both;
	}
	
	.iziToast.fadeOutRight {
		-webkit-animation: iziT-fadeOutRight 0.5s ease both;
		animation: iziT-fadeOutRight 0.5s ease both;
	}
	
	.iziToast.flipOutX {
		-webkit-backface-visibility: visible !important;
		backface-visibility: visible !important;
		-webkit-animation: iziT-flipOutX 0.7s cubic-bezier(0.4, 0.45, 0.15, 0.91) both;
		animation: iziT-flipOutX 0.7s cubic-bezier(0.4, 0.45, 0.15, 0.91) both;
	}
	
	.iziToast-overlay.fadeIn {
		-webkit-animation: iziT-fadeIn 0.5s ease both;
		animation: iziT-fadeIn 0.5s ease both;
	}
	
	.iziToast-overlay.fadeOut {
		-webkit-animation: iziT-fadeOut 0.7s ease both;
		animation: iziT-fadeOut 0.7s ease both;
	}
	
	@-webkit-keyframes iziT-revealIn {
		0% {
			opacity: 0;
			-webkit-transform: scale3d(0.3, 0.3, 1);
		}
		100% {
			opacity: 1;
		}
	}
	
	@-webkit-keyframes iziT-slideIn {
		0% {
			opacity: 0;
			-webkit-transform: translateX(50px);
		}
		100% {
			opacity: 1;
			-webkit-transform: translateX(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInLeft {
		0% {
			opacity: 0;
			-webkit-transform: translateX(280px);
		}
		50% {
			opacity: 1;
			-webkit-transform: translateX(-20px);
		}
		70% {
			-webkit-transform: translateX(10px);
		}
		100% {
			-webkit-transform: translateX(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInRight {
		0% {
			opacity: 0;
			-webkit-transform: translateX(-280px);
		}
		50% {
			opacity: 1;
			-webkit-transform: translateX(20px);
		}
		70% {
			-webkit-transform: translateX(-10px);
		}
		100% {
			-webkit-transform: translateX(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInDown {
		0% {
			opacity: 0;
			-webkit-transform: translateY(-200px);
		}
		50% {
			opacity: 1;
			-webkit-transform: translateY(10px);
		}
		70% {
			-webkit-transform: translateY(-5px);
		}
		100% {
			-webkit-transform: translateY(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInUp {
		0% {
			opacity: 0;
			-webkit-transform: translateY(200px);
		}
		50% {
			opacity: 1;
			-webkit-transform: translateY(-10px);
		}
		70% {
			-webkit-transform: translateY(5px);
		}
		100% {
			-webkit-transform: translateY(0);
		}
	}
	
	@-webkit-keyframes iziT-fadeIn {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}
	
	@-webkit-keyframes iziT-fadeInUp {
		from {
			opacity: 0;
			transform: translate3d(0, 100%, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-fadeInDown {
		from {
			opacity: 0;
			transform: translate3d(0, -100%, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-fadeInLeft {
		from {
			opacity: 0;
			transform: translate3d(300px, 0, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-fadeInRight {
		from {
			opacity: 0;
			transform: translate3d(-300px, 0, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-flipInX {
		from {
			transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
			opacity: 0;
		}
		40% {
			transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
		}
		60% {
			transform: perspective(400px) rotate3d(1, 0, 0, 10deg);
			opacity: 1;
		}
		80% {
			transform: perspective(400px) rotate3d(1, 0, 0, -5deg);
		}
		to {
			transform: perspective(400px);
		}
	}
	
	@-webkit-keyframes iziT-fadeOut {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
		}
	}
	
	@-webkit-keyframes iziT-fadeOutDown {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(0, 100%, 0);
		}
	}
	
	@-webkit-keyframes iziT-fadeOutUp {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(0, -100%, 0);
		}
	}
	
	@-webkit-keyframes iziT-fadeOutLeft {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(-200px, 0, 0);
		}
	}
	
	@-webkit-keyframes iziT-fadeOutRight {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(200px, 0, 0);
		}
	}
	
	@-webkit-keyframes iziT-flipOutX {
		from {
			transform: perspective(400px);
		}
		30% {
			transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
			opacity: 1;
		}
		to {
			transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
			opacity: 0;
		}
	}
	
	@-webkit-keyframes iziT-revealIn {
		0% {
			opacity: 0;
			transform: scale3d(0.3, 0.3, 1);
		}
		100% {
			opacity: 1;
		}
	}
	
	@keyframes iziT-revealIn {
		0% {
			opacity: 0;
			transform: scale3d(0.3, 0.3, 1);
		}
		100% {
			opacity: 1;
		}
	}
	
	@-webkit-keyframes iziT-slideIn {
		0% {
			opacity: 0;
			transform: translateX(50px);
		}
		100% {
			opacity: 1;
			transform: translateX(0);
		}
	}
	
	@keyframes iziT-slideIn {
		0% {
			opacity: 0;
			transform: translateX(50px);
		}
		100% {
			opacity: 1;
			transform: translateX(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInLeft {
		0% {
			opacity: 0;
			transform: translateX(280px);
		}
		50% {
			opacity: 1;
			transform: translateX(-20px);
		}
		70% {
			transform: translateX(10px);
		}
		100% {
			transform: translateX(0);
		}
	}
	
	@keyframes iziT-bounceInLeft {
		0% {
			opacity: 0;
			transform: translateX(280px);
		}
		50% {
			opacity: 1;
			transform: translateX(-20px);
		}
		70% {
			transform: translateX(10px);
		}
		100% {
			transform: translateX(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInRight {
		0% {
			opacity: 0;
			transform: translateX(-280px);
		}
		50% {
			opacity: 1;
			transform: translateX(20px);
		}
		70% {
			transform: translateX(-10px);
		}
		100% {
			transform: translateX(0);
		}
	}
	
	@keyframes iziT-bounceInRight {
		0% {
			opacity: 0;
			transform: translateX(-280px);
		}
		50% {
			opacity: 1;
			transform: translateX(20px);
		}
		70% {
			transform: translateX(-10px);
		}
		100% {
			transform: translateX(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInDown {
		0% {
			opacity: 0;
			transform: translateY(-200px);
		}
		50% {
			opacity: 1;
			transform: translateY(10px);
		}
		70% {
			transform: translateY(-5px);
		}
		100% {
			transform: translateY(0);
		}
	}
	
	@keyframes iziT-bounceInDown {
		0% {
			opacity: 0;
			transform: translateY(-200px);
		}
		50% {
			opacity: 1;
			transform: translateY(10px);
		}
		70% {
			transform: translateY(-5px);
		}
		100% {
			transform: translateY(0);
		}
	}
	
	@-webkit-keyframes iziT-bounceInUp {
		0% {
			opacity: 0;
			transform: translateY(200px);
		}
		50% {
			opacity: 1;
			transform: translateY(-10px);
		}
		70% {
			transform: translateY(5px);
		}
		100% {
			transform: translateY(0);
		}
	}
	
	@keyframes iziT-bounceInUp {
		0% {
			opacity: 0;
			transform: translateY(200px);
		}
		50% {
			opacity: 1;
			transform: translateY(-10px);
		}
		70% {
			transform: translateY(5px);
		}
		100% {
			transform: translateY(0);
		}
	}
	
	@-webkit-keyframes iziT-fadeIn {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}
	
	@keyframes iziT-fadeIn {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}
	
	@-webkit-keyframes iziT-fadeInUp {
		from {
			opacity: 0;
			transform: translate3d(0, 100%, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@keyframes iziT-fadeInUp {
		from {
			opacity: 0;
			transform: translate3d(0, 100%, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-fadeInDown {
		from {
			opacity: 0;
			transform: translate3d(0, -100%, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@keyframes iziT-fadeInDown {
		from {
			opacity: 0;
			transform: translate3d(0, -100%, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-fadeInLeft {
		from {
			opacity: 0;
			transform: translate3d(300px, 0, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@keyframes iziT-fadeInLeft {
		from {
			opacity: 0;
			transform: translate3d(300px, 0, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-fadeInRight {
		from {
			opacity: 0;
			transform: translate3d(-300px, 0, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@keyframes iziT-fadeInRight {
		from {
			opacity: 0;
			transform: translate3d(-300px, 0, 0);
		}
		to {
			opacity: 1;
			transform: none;
		}
	}
	
	@-webkit-keyframes iziT-flipInX {
		from {
			transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
			opacity: 0;
		}
		40% {
			transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
		}
		60% {
			transform: perspective(400px) rotate3d(1, 0, 0, 10deg);
			opacity: 1;
		}
		80% {
			transform: perspective(400px) rotate3d(1, 0, 0, -5deg);
		}
		to {
			transform: perspective(400px);
		}
	}
	
	@keyframes iziT-flipInX {
		from {
			transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
			opacity: 0;
		}
		40% {
			transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
		}
		60% {
			transform: perspective(400px) rotate3d(1, 0, 0, 10deg);
			opacity: 1;
		}
		80% {
			transform: perspective(400px) rotate3d(1, 0, 0, -5deg);
		}
		to {
			transform: perspective(400px);
		}
	}
	
	@-webkit-keyframes iziT-fadeOut {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
		}
	}
	
	@keyframes iziT-fadeOut {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
		}
	}
	
	@-webkit-keyframes iziT-fadeOutDown {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(0, 100%, 0);
		}
	}
	
	@keyframes iziT-fadeOutDown {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(0, 100%, 0);
		}
	}
	
	@-webkit-keyframes iziT-fadeOutUp {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(0, -100%, 0);
		}
	}
	
	@keyframes iziT-fadeOutUp {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(0, -100%, 0);
		}
	}
	
	@-webkit-keyframes iziT-fadeOutLeft {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(-200px, 0, 0);
		}
	}
	
	@keyframes iziT-fadeOutLeft {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(-200px, 0, 0);
		}
	}
	
	@-webkit-keyframes iziT-fadeOutRight {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(200px, 0, 0);
		}
	}
	
	@keyframes iziT-fadeOutRight {
		from {
			opacity: 1;
		}
		to {
			opacity: 0;
			transform: translate3d(200px, 0, 0);
		}
	}
	
	@-webkit-keyframes iziT-flipOutX {
		from {
			transform: perspective(400px);
		}
		30% {
			transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
			opacity: 1;
		}
		to {
			transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
			opacity: 0;
		}
	}
	
	@keyframes iziT-flipOutX {
		from {
			transform: perspective(400px);
		}
		30% {
			transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
			opacity: 1;
		}
		to {
			transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
			opacity: 0;
		}
	}
	</style>
	<style type="text/css">
	.smooth-scrollbar[data-v-0c000dc0] {
		width: 100%;
		height: 100%;
	}
	</style>
	<style type="text/css">
	@-webkit-keyframes swal2-show {
		0% {
			transform: scale(.7)
		}
		45% {
			transform: scale(1.05)
		}
		80% {
			transform: scale(.95)
		}
		100% {
			transform: scale(1)
		}
	}
	
	@keyframes swal2-show {
		0% {
			transform: scale(.7)
		}
		45% {
			transform: scale(1.05)
		}
		80% {
			transform: scale(.95)
		}
		100% {
			transform: scale(1)
		}
	}
	
	@-webkit-keyframes swal2-hide {
		0% {
			transform: scale(1);
			opacity: 1
		}
		100% {
			transform: scale(.5);
			opacity: 0
		}
	}
	
	@keyframes swal2-hide {
		0% {
			transform: scale(1);
			opacity: 1
		}
		100% {
			transform: scale(.5);
			opacity: 0
		}
	}
	
	@-webkit-keyframes swal2-animate-success-line-tip {
		0% {
			top: 1.1875em;
			left: .0625em;
			width: 0
		}
		54% {
			top: 1.0625em;
			left: .125em;
			width: 0
		}
		70% {
			top: 2.1875em;
			left: -.375em;
			width: 3.125em
		}
		84% {
			top: 3em;
			left: 1.3125em;
			width: 1.0625em
		}
		100% {
			top: 2.8125em;
			left: .875em;
			width: 1.5625em
		}
	}
	
	@keyframes swal2-animate-success-line-tip {
		0% {
			top: 1.1875em;
			left: .0625em;
			width: 0
		}
		54% {
			top: 1.0625em;
			left: .125em;
			width: 0
		}
		70% {
			top: 2.1875em;
			left: -.375em;
			width: 3.125em
		}
		84% {
			top: 3em;
			left: 1.3125em;
			width: 1.0625em
		}
		100% {
			top: 2.8125em;
			left: .875em;
			width: 1.5625em
		}
	}
	
	@-webkit-keyframes swal2-animate-success-line-long {
		0% {
			top: 3.375em;
			right: 2.875em;
			width: 0
		}
		65% {
			top: 3.375em;
			right: 2.875em;
			width: 0
		}
		84% {
			top: 2.1875em;
			right: 0;
			width: 3.4375em
		}
		100% {
			top: 2.375em;
			right: .5em;
			width: 2.9375em
		}
	}
	
	@keyframes swal2-animate-success-line-long {
		0% {
			top: 3.375em;
			right: 2.875em;
			width: 0
		}
		65% {
			top: 3.375em;
			right: 2.875em;
			width: 0
		}
		84% {
			top: 2.1875em;
			right: 0;
			width: 3.4375em
		}
		100% {
			top: 2.375em;
			right: .5em;
			width: 2.9375em
		}
	}
	
	@-webkit-keyframes swal2-rotate-success-circular-line {
		0% {
			transform: rotate(-45deg)
		}
		5% {
			transform: rotate(-45deg)
		}
		12% {
			transform: rotate(-405deg)
		}
		100% {
			transform: rotate(-405deg)
		}
	}
	
	@keyframes swal2-rotate-success-circular-line {
		0% {
			transform: rotate(-45deg)
		}
		5% {
			transform: rotate(-45deg)
		}
		12% {
			transform: rotate(-405deg)
		}
		100% {
			transform: rotate(-405deg)
		}
	}
	
	@-webkit-keyframes swal2-animate-error-x-mark {
		0% {
			margin-top: 1.625em;
			transform: scale(.4);
			opacity: 0
		}
		50% {
			margin-top: 1.625em;
			transform: scale(.4);
			opacity: 0
		}
		80% {
			margin-top: -.375em;
			transform: scale(1.15)
		}
		100% {
			margin-top: 0;
			transform: scale(1);
			opacity: 1
		}
	}
	
	@keyframes swal2-animate-error-x-mark {
		0% {
			margin-top: 1.625em;
			transform: scale(.4);
			opacity: 0
		}
		50% {
			margin-top: 1.625em;
			transform: scale(.4);
			opacity: 0
		}
		80% {
			margin-top: -.375em;
			transform: scale(1.15)
		}
		100% {
			margin-top: 0;
			transform: scale(1);
			opacity: 1
		}
	}
	
	@-webkit-keyframes swal2-animate-error-icon {
		0% {
			transform: rotateX(100deg);
			opacity: 0
		}
		100% {
			transform: rotateX(0);
			opacity: 1
		}
	}
	
	@keyframes swal2-animate-error-icon {
		0% {
			transform: rotateX(100deg);
			opacity: 0
		}
		100% {
			transform: rotateX(0);
			opacity: 1
		}
	}
	
	body.swal2-toast-shown .swal2-container {
		background-color: transparent
	}
	
	body.swal2-toast-shown .swal2-container.swal2-shown {
		background-color: transparent
	}
	
	body.swal2-toast-shown .swal2-container.swal2-top {
		top: 0;
		right: auto;
		bottom: auto;
		left: 50%;
		transform: translateX(-50%)
	}
	
	body.swal2-toast-shown .swal2-container.swal2-top-end,
	body.swal2-toast-shown .swal2-container.swal2-top-right {
		top: 0;
		right: 0;
		bottom: auto;
		left: auto
	}
	
	body.swal2-toast-shown .swal2-container.swal2-top-left,
	body.swal2-toast-shown .swal2-container.swal2-top-start {
		top: 0;
		right: auto;
		bottom: auto;
		left: 0
	}
	
	body.swal2-toast-shown .swal2-container.swal2-center-left,
	body.swal2-toast-shown .swal2-container.swal2-center-start {
		top: 50%;
		right: auto;
		bottom: auto;
		left: 0;
		transform: translateY(-50%)
	}
	
	body.swal2-toast-shown .swal2-container.swal2-center {
		top: 50%;
		right: auto;
		bottom: auto;
		left: 50%;
		transform: translate(-50%, -50%)
	}
	
	body.swal2-toast-shown .swal2-container.swal2-center-end,
	body.swal2-toast-shown .swal2-container.swal2-center-right {
		top: 50%;
		right: 0;
		bottom: auto;
		left: auto;
		transform: translateY(-50%)
	}
	
	body.swal2-toast-shown .swal2-container.swal2-bottom-left,
	body.swal2-toast-shown .swal2-container.swal2-bottom-start {
		top: auto;
		right: auto;
		bottom: 0;
		left: 0
	}
	
	body.swal2-toast-shown .swal2-container.swal2-bottom {
		top: auto;
		right: auto;
		bottom: 0;
		left: 50%;
		transform: translateX(-50%)
	}
	
	body.swal2-toast-shown .swal2-container.swal2-bottom-end,
	body.swal2-toast-shown .swal2-container.swal2-bottom-right {
		top: auto;
		right: 0;
		bottom: 0;
		left: auto
	}
	
	body.swal2-toast-column .swal2-toast {
		flex-direction: column;
		align-items: stretch
	}
	
	body.swal2-toast-column .swal2-toast .swal2-actions {
		flex: 1;
		align-self: stretch;
		height: 2.2em;
		margin-top: .3125em
	}
	
	body.swal2-toast-column .swal2-toast .swal2-loading {
		justify-content: center
	}
	
	body.swal2-toast-column .swal2-toast .swal2-input {
		height: 2em;
		margin: .3125em auto;
		font-size: 1em
	}
	
	body.swal2-toast-column .swal2-toast .swal2-validation-message {
		font-size: 1em
	}
	
	.swal2-popup.swal2-toast {
		flex-direction: row;
		align-items: center;
		width: auto;
		padding: .625em;
		box-shadow: 0 0 .625em #d9d9d9;
		overflow-y: hidden
	}
	
	.swal2-popup.swal2-toast .swal2-header {
		flex-direction: row
	}
	
	.swal2-popup.swal2-toast .swal2-title {
		flex-grow: 1;
		justify-content: flex-start;
		margin: 0 .6em;
		font-size: 1em
	}
	
	.swal2-popup.swal2-toast .swal2-footer {
		margin: .5em 0 0;
		padding: .5em 0 0;
		font-size: .8em
	}
	
	.swal2-popup.swal2-toast .swal2-close {
		position: initial;
		width: .8em;
		height: .8em;
		line-height: .8
	}
	
	.swal2-popup.swal2-toast .swal2-content {
		justify-content: flex-start;
		font-size: 1em
	}
	
	.swal2-popup.swal2-toast .swal2-icon {
		width: 2em;
		min-width: 2em;
		height: 2em;
		margin: 0
	}
	
	.swal2-popup.swal2-toast .swal2-icon-text {
		font-size: 2em;
		font-weight: 700;
		line-height: 1em
	}
	
	.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring {
		width: 2em;
		height: 2em
	}
	
	.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
		top: .875em;
		width: 1.375em
	}
	
	.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
		left: .3125em
	}
	
	.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
		right: .3125em
	}
	
	.swal2-popup.swal2-toast .swal2-actions {
		height: auto;
		margin: 0 .3125em
	}
	
	.swal2-popup.swal2-toast .swal2-styled {
		margin: 0 .3125em;
		padding: .3125em .625em;
		font-size: 1em
	}
	
	.swal2-popup.swal2-toast .swal2-styled:focus {
		box-shadow: 0 0 0 .0625em #fff, 0 0 0 .125em rgba(50, 100, 150, .4)
	}
	
	.swal2-popup.swal2-toast .swal2-success {
		border-color: #a5dc86
	}
	
	.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line] {
		position: absolute;
		width: 2em;
		height: 2.8125em;
		transform: rotate(45deg);
		border-radius: 50%
	}
	
	.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left] {
		top: -.25em;
		left: -.9375em;
		transform: rotate(-45deg);
		transform-origin: 2em 2em;
		border-radius: 4em 0 0 4em
	}
	
	.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right] {
		top: -.25em;
		left: .9375em;
		transform-origin: 0 2em;
		border-radius: 0 4em 4em 0
	}
	
	.swal2-popup.swal2-toast .swal2-success .swal2-success-ring {
		width: 2em;
		height: 2em
	}
	
	.swal2-popup.swal2-toast .swal2-success .swal2-success-fix {
		top: 0;
		left: .4375em;
		width: .4375em;
		height: 2.6875em
	}
	
	.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line] {
		height: .3125em
	}
	
	.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip] {
		top: 1.125em;
		left: .1875em;
		width: .75em
	}
	
	.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long] {
		top: .9375em;
		right: .1875em;
		width: 1.375em
	}
	
	.swal2-popup.swal2-toast.swal2-show {
		-webkit-animation: showSweetToast .5s;
		animation: showSweetToast .5s
	}
	
	.swal2-popup.swal2-toast.swal2-hide {
		-webkit-animation: hideSweetToast .2s forwards;
		animation: hideSweetToast .2s forwards
	}
	
	.swal2-popup.swal2-toast .swal2-animate-success-icon .swal2-success-line-tip {
		-webkit-animation: animate-toast-success-tip .75s;
		animation: animate-toast-success-tip .75s
	}
	
	.swal2-popup.swal2-toast .swal2-animate-success-icon .swal2-success-line-long {
		-webkit-animation: animate-toast-success-long .75s;
		animation: animate-toast-success-long .75s
	}
	
	@-webkit-keyframes showSweetToast {
		0% {
			transform: translateY(-.625em) rotateZ(2deg);
			opacity: 0
		}
		33% {
			transform: translateY(0) rotateZ(-2deg);
			opacity: .5
		}
		66% {
			transform: translateY(.3125em) rotateZ(2deg);
			opacity: .7
		}
		100% {
			transform: translateY(0) rotateZ(0);
			opacity: 1
		}
	}
	
	@keyframes showSweetToast {
		0% {
			transform: translateY(-.625em) rotateZ(2deg);
			opacity: 0
		}
		33% {
			transform: translateY(0) rotateZ(-2deg);
			opacity: .5
		}
		66% {
			transform: translateY(.3125em) rotateZ(2deg);
			opacity: .7
		}
		100% {
			transform: translateY(0) rotateZ(0);
			opacity: 1
		}
	}
	
	@-webkit-keyframes hideSweetToast {
		0% {
			opacity: 1
		}
		33% {
			opacity: .5
		}
		100% {
			transform: rotateZ(1deg);
			opacity: 0
		}
	}
	
	@keyframes hideSweetToast {
		0% {
			opacity: 1
		}
		33% {
			opacity: .5
		}
		100% {
			transform: rotateZ(1deg);
			opacity: 0
		}
	}
	
	@-webkit-keyframes animate-toast-success-tip {
		0% {
			top: .5625em;
			left: .0625em;
			width: 0
		}
		54% {
			top: .125em;
			left: .125em;
			width: 0
		}
		70% {
			top: .625em;
			left: -.25em;
			width: 1.625em
		}
		84% {
			top: 1.0625em;
			left: .75em;
			width: .5em
		}
		100% {
			top: 1.125em;
			left: .1875em;
			width: .75em
		}
	}
	
	@keyframes animate-toast-success-tip {
		0% {
			top: .5625em;
			left: .0625em;
			width: 0
		}
		54% {
			top: .125em;
			left: .125em;
			width: 0
		}
		70% {
			top: .625em;
			left: -.25em;
			width: 1.625em
		}
		84% {
			top: 1.0625em;
			left: .75em;
			width: .5em
		}
		100% {
			top: 1.125em;
			left: .1875em;
			width: .75em
		}
	}
	
	@-webkit-keyframes animate-toast-success-long {
		0% {
			top: 1.625em;
			right: 1.375em;
			width: 0
		}
		65% {
			top: 1.25em;
			right: .9375em;
			width: 0
		}
		84% {
			top: .9375em;
			right: 0;
			width: 1.125em
		}
		100% {
			top: .9375em;
			right: .1875em;
			width: 1.375em
		}
	}
	
	@keyframes animate-toast-success-long {
		0% {
			top: 1.625em;
			right: 1.375em;
			width: 0
		}
		65% {
			top: 1.25em;
			right: .9375em;
			width: 0
		}
		84% {
			top: .9375em;
			right: 0;
			width: 1.125em
		}
		100% {
			top: .9375em;
			right: .1875em;
			width: 1.375em
		}
	}
	
	body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
		overflow: hidden
	}
	
	body.swal2-height-auto {
		height: auto!important
	}
	
	body.swal2-no-backdrop .swal2-shown {
		top: auto;
		right: auto;
		bottom: auto;
		left: auto;
		background-color: transparent
	}
	
	body.swal2-no-backdrop .swal2-shown>.swal2-modal {
		box-shadow: 0 0 10px rgba(0, 0, 0, .4)
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-top {
		top: 0;
		left: 50%;
		transform: translateX(-50%)
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-top-left,
	body.swal2-no-backdrop .swal2-shown.swal2-top-start {
		top: 0;
		left: 0
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-top-end,
	body.swal2-no-backdrop .swal2-shown.swal2-top-right {
		top: 0;
		right: 0
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-center {
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%)
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-center-left,
	body.swal2-no-backdrop .swal2-shown.swal2-center-start {
		top: 50%;
		left: 0;
		transform: translateY(-50%)
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-center-end,
	body.swal2-no-backdrop .swal2-shown.swal2-center-right {
		top: 50%;
		right: 0;
		transform: translateY(-50%)
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-bottom {
		bottom: 0;
		left: 50%;
		transform: translateX(-50%)
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-bottom-left,
	body.swal2-no-backdrop .swal2-shown.swal2-bottom-start {
		bottom: 0;
		left: 0
	}
	
	body.swal2-no-backdrop .swal2-shown.swal2-bottom-end,
	body.swal2-no-backdrop .swal2-shown.swal2-bottom-right {
		right: 0;
		bottom: 0
	}
	
	.swal2-container {
		display: flex;
		position: fixed;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		flex-direction: row;
		align-items: center;
		justify-content: center;
		padding: 10px;
		background-color: transparent;
		z-index: 1060;
		overflow-x: hidden;
		-webkit-overflow-scrolling: touch
	}
	
	.swal2-container.swal2-top {
		align-items: flex-start
	}
	
	.swal2-container.swal2-top-left,
	.swal2-container.swal2-top-start {
		align-items: flex-start;
		justify-content: flex-start
	}
	
	.swal2-container.swal2-top-end,
	.swal2-container.swal2-top-right {
		align-items: flex-start;
		justify-content: flex-end
	}
	
	.swal2-container.swal2-center {
		align-items: center
	}
	
	.swal2-container.swal2-center-left,
	.swal2-container.swal2-center-start {
		align-items: center;
		justify-content: flex-start
	}
	
	.swal2-container.swal2-center-end,
	.swal2-container.swal2-center-right {
		align-items: center;
		justify-content: flex-end
	}
	
	.swal2-container.swal2-bottom {
		align-items: flex-end
	}
	
	.swal2-container.swal2-bottom-left,
	.swal2-container.swal2-bottom-start {
		align-items: flex-end;
		justify-content: flex-start
	}
	
	.swal2-container.swal2-bottom-end,
	.swal2-container.swal2-bottom-right {
		align-items: flex-end;
		justify-content: flex-end
	}
	
	.swal2-container.swal2-grow-fullscreen>.swal2-modal {
		display: flex!important;
		flex: 1;
		align-self: stretch;
		justify-content: center
	}
	
	.swal2-container.swal2-grow-row>.swal2-modal {
		display: flex!important;
		flex: 1;
		align-content: center;
		justify-content: center
	}
	
	.swal2-container.swal2-grow-column {
		flex: 1;
		flex-direction: column
	}
	
	.swal2-container.swal2-grow-column.swal2-bottom,
	.swal2-container.swal2-grow-column.swal2-center,
	.swal2-container.swal2-grow-column.swal2-top {
		align-items: center
	}
	
	.swal2-container.swal2-grow-column.swal2-bottom-left,
	.swal2-container.swal2-grow-column.swal2-bottom-start,
	.swal2-container.swal2-grow-column.swal2-center-left,
	.swal2-container.swal2-grow-column.swal2-center-start,
	.swal2-container.swal2-grow-column.swal2-top-left,
	.swal2-container.swal2-grow-column.swal2-top-start {
		align-items: flex-start
	}
	
	.swal2-container.swal2-grow-column.swal2-bottom-end,
	.swal2-container.swal2-grow-column.swal2-bottom-right,
	.swal2-container.swal2-grow-column.swal2-center-end,
	.swal2-container.swal2-grow-column.swal2-center-right,
	.swal2-container.swal2-grow-column.swal2-top-end,
	.swal2-container.swal2-grow-column.swal2-top-right {
		align-items: flex-end
	}
	
	.swal2-container.swal2-grow-column>.swal2-modal {
		display: flex!important;
		flex: 1;
		align-content: center;
		justify-content: center
	}
	
	.swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal {
		margin: auto
	}
	
	@media all and (-ms-high-contrast:none),
	(-ms-high-contrast:active) {
		.swal2-container .swal2-modal {
			margin: 0!important
		}
	}
	
	.swal2-container.swal2-fade {
		transition: background-color .1s
	}
	
	.swal2-container.swal2-shown {
		background-color: rgba(0, 0, 0, .4)
	}
	
	.swal2-popup {
		display: none;
		position: relative;
		flex-direction: column;
		justify-content: center;
		width: 32em;
		max-width: 100%;
		padding: 1.25em;
		border-radius: .3125em;
		background: #fff;
		font-family: inherit;
		font-size: 1rem;
		box-sizing: border-box
	}
	
	.swal2-popup:focus {
		outline: 0
	}
	
	.swal2-popup.swal2-loading {
		overflow-y: hidden
	}
	
	.swal2-popup .swal2-header {
		display: flex;
		flex-direction: column;
		align-items: center
	}
	
	.swal2-popup .swal2-title {
		display: block;
		position: relative;
		max-width: 100%;
		margin: 0 0 .4em;
		padding: 0;
		color: #595959;
		font-size: 1.875em;
		font-weight: 600;
		text-align: center;
		text-transform: none;
		word-wrap: break-word
	}
	
	.swal2-popup .swal2-actions {
		flex-wrap: wrap;
		align-items: center;
		justify-content: center;
		margin: 1.25em auto 0;
		z-index: 1
	}
	
	.swal2-popup .swal2-actions:not(.swal2-loading) .swal2-styled[disabled] {
		opacity: .4
	}
	
	.swal2-popup .swal2-actions:not(.swal2-loading) .swal2-styled:hover {
		background-image: linear-gradient(rgba(0, 0, 0, .1), rgba(0, 0, 0, .1))
	}
	
	.swal2-popup .swal2-actions:not(.swal2-loading) .swal2-styled:active {
		background-image: linear-gradient(rgba(0, 0, 0, .2), rgba(0, 0, 0, .2))
	}
	
	.swal2-popup .swal2-actions.swal2-loading .swal2-styled.swal2-confirm {
		width: 2.5em;
		height: 2.5em;
		margin: .46875em;
		padding: 0;
		border: .25em solid transparent;
		border-radius: 100%;
		border-color: transparent;
		background-color: transparent!important;
		color: transparent;
		cursor: default;
		box-sizing: border-box;
		-webkit-animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
		animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none
	}
	
	.swal2-popup .swal2-actions.swal2-loading .swal2-styled.swal2-cancel {
		margin-right: 30px;
		margin-left: 30px
	}
	
	.swal2-popup .swal2-actions.swal2-loading:not(.swal2-styled).swal2-confirm::after {
		display: inline-block;
		width: 15px;
		height: 15px;
		margin-left: 5px;
		border: 3px solid #999;
		border-radius: 50%;
		border-right-color: transparent;
		box-shadow: 1px 1px 1px #fff;
		content: '';
		-webkit-animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
		animation: swal2-rotate-loading 1.5s linear 0s infinite normal
	}
	
	.swal2-popup .swal2-styled {
		margin: .3125em;
		padding: .625em 2em;
		font-weight: 500;
		box-shadow: none
	}
	
	.swal2-popup .swal2-styled:not([disabled]) {
		cursor: pointer
	}
	
	.swal2-popup .swal2-styled.swal2-confirm {
		border: 0;
		border-radius: .25em;
		background: initial;
		background-color: #3085d6;
		color: #fff;
		font-size: 1.0625em
	}
	
	.swal2-popup .swal2-styled.swal2-cancel {
		border: 0;
		border-radius: .25em;
		background: initial;
		background-color: #aaa;
		color: #fff;
		font-size: 1.0625em
	}
	
	.swal2-popup .swal2-styled:focus {
		outline: 0;
		box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(50, 100, 150, .4)
	}
	
	.swal2-popup .swal2-styled::-moz-focus-inner {
		border: 0
	}
	
	.swal2-popup .swal2-footer {
		justify-content: center;
		margin: 1.25em 0 0;
		padding: 1em 0 0;
		border-top: 1px solid #eee;
		color: #545454;
		font-size: 1em
	}
	
	.swal2-popup .swal2-image {
		max-width: 100%;
		margin: 1.25em auto
	}
	
	.swal2-popup .swal2-close {
		position: absolute;
		top: 0;
		right: 0;
		justify-content: center;
		width: 1.2em;
		height: 1.2em;
		padding: 0;
		transition: color .1s ease-out;
		border: none;
		border-radius: 0;
		outline: initial;
		background: 0 0;
		color: #ccc;
		font-family: serif;
		font-size: 2.5em;
		line-height: 1.2;
		cursor: pointer;
		overflow: hidden
	}
	
	.swal2-popup .swal2-close:hover {
		transform: none;
		color: #f27474
	}
	
	.swal2-popup>.swal2-checkbox,
	.swal2-popup>.swal2-file,
	.swal2-popup>.swal2-input,
	.swal2-popup>.swal2-radio,
	.swal2-popup>.swal2-select,
	.swal2-popup>.swal2-textarea {
		display: none
	}
	
	.swal2-popup .swal2-content {
		justify-content: center;
		margin: 0;
		padding: 0;
		color: #545454;
		font-size: 1.125em;
		font-weight: 300;
		line-height: normal;
		z-index: 1;
		word-wrap: break-word
	}
	
	.swal2-popup #swal2-content {
		text-align: center
	}
	
	.swal2-popup .swal2-checkbox,
	.swal2-popup .swal2-file,
	.swal2-popup .swal2-input,
	.swal2-popup .swal2-radio,
	.swal2-popup .swal2-select,
	.swal2-popup .swal2-textarea {
		margin: 1em auto
	}
	
	.swal2-popup .swal2-file,
	.swal2-popup .swal2-input,
	.swal2-popup .swal2-textarea {
		width: 100%;
		transition: border-color .3s, box-shadow .3s;
		border: 1px solid #d9d9d9;
		border-radius: .1875em;
		font-size: 1.125em;
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06);
		box-sizing: border-box
	}
	
	.swal2-popup .swal2-file.swal2-inputerror,
	.swal2-popup .swal2-input.swal2-inputerror,
	.swal2-popup .swal2-textarea.swal2-inputerror {
		border-color: #f27474!important;
		box-shadow: 0 0 2px #f27474!important
	}
	
	.swal2-popup .swal2-file:focus,
	.swal2-popup .swal2-input:focus,
	.swal2-popup .swal2-textarea:focus {
		border: 1px solid #b4dbed;
		outline: 0;
		box-shadow: 0 0 3px #c4e6f5
	}
	
	.swal2-popup .swal2-file::-webkit-input-placeholder,
	.swal2-popup .swal2-input::-webkit-input-placeholder,
	.swal2-popup .swal2-textarea::-webkit-input-placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-file:-ms-input-placeholder,
	.swal2-popup .swal2-input:-ms-input-placeholder,
	.swal2-popup .swal2-textarea:-ms-input-placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-file::-ms-input-placeholder,
	.swal2-popup .swal2-input::-ms-input-placeholder,
	.swal2-popup .swal2-textarea::-ms-input-placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-file::-webkit-input-placeholder,
	.swal2-popup .swal2-input::-webkit-input-placeholder,
	.swal2-popup .swal2-textarea::-webkit-input-placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-file::-moz-placeholder,
	.swal2-popup .swal2-input::-moz-placeholder,
	.swal2-popup .swal2-textarea::-moz-placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-file:-ms-input-placeholder,
	.swal2-popup .swal2-input:-ms-input-placeholder,
	.swal2-popup .swal2-textarea:-ms-input-placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-file::-ms-input-placeholder,
	.swal2-popup .swal2-input::-ms-input-placeholder,
	.swal2-popup .swal2-textarea::-ms-input-placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-file::placeholder,
	.swal2-popup .swal2-input::placeholder,
	.swal2-popup .swal2-textarea::placeholder {
		color: #ccc
	}
	
	.swal2-popup .swal2-range input {
		width: 80%
	}
	
	.swal2-popup .swal2-range output {
		width: 20%;
		font-weight: 600;
		text-align: center
	}
	
	.swal2-popup .swal2-range input,
	.swal2-popup .swal2-range output {
		height: 2.625em;
		margin: 1em auto;
		padding: 0;
		font-size: 1.125em;
		line-height: 2.625em
	}
	
	.swal2-popup .swal2-input {
		height: 2.625em;
		padding: 0 .75em
	}
	
	.swal2-popup .swal2-input[type=number] {
		max-width: 10em
	}
	
	.swal2-popup .swal2-file {
		font-size: 1.125em
	}
	
	.swal2-popup .swal2-textarea {
		height: 6.75em;
		padding: .75em
	}
	
	.swal2-popup .swal2-select {
		min-width: 50%;
		max-width: 100%;
		padding: .375em .625em;
		color: #545454;
		font-size: 1.125em
	}
	
	.swal2-popup .swal2-checkbox,
	.swal2-popup .swal2-radio {
		align-items: center;
		justify-content: center
	}
	
	.swal2-popup .swal2-checkbox label,
	.swal2-popup .swal2-radio label {
		margin: 0 .6em;
		font-size: 1.125em
	}
	
	.swal2-popup .swal2-checkbox input,
	.swal2-popup .swal2-radio input {
		margin: 0 .4em
	}
	
	.swal2-popup .swal2-validation-message {
		display: none;
		align-items: center;
		justify-content: center;
		padding: .625em;
		background: #f0f0f0;
		color: #666;
		font-size: 1em;
		font-weight: 300;
		overflow: hidden
	}
	
	.swal2-popup .swal2-validation-message::before {
		display: inline-block;
		width: 1.5em;
		min-width: 1.5em;
		height: 1.5em;
		margin: 0 .625em;
		border-radius: 50%;
		background-color: #f27474;
		color: #fff;
		font-weight: 600;
		line-height: 1.5em;
		text-align: center;
		content: '!';
		zoom: normal
	}
	
	@supports (-ms-accelerator:true) {
		.swal2-range input {
			width: 100%!important
		}
		.swal2-range output {
			display: none
		}
	}
	
	@media all and (-ms-high-contrast:none),
	(-ms-high-contrast:active) {
		.swal2-range input {
			width: 100%!important
		}
		.swal2-range output {
			display: none
		}
	}
	
	@-moz-document url-prefix() {
		.swal2-close:focus {
			outline: 2px solid rgba(50, 100, 150, .4)
		}
	}
	
	.swal2-icon {
		position: relative;
		justify-content: center;
		width: 5em;
		height: 5em;
		margin: 1.25em auto 1.875em;
		border: .25em solid transparent;
		border-radius: 50%;
		line-height: 5em;
		cursor: default;
		box-sizing: content-box;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		zoom: normal
	}
	
	.swal2-icon-text {
		font-size: 3.75em
	}
	
	.swal2-icon.swal2-error {
		border-color: #f27474
	}
	
	.swal2-icon.swal2-error .swal2-x-mark {
		position: relative;
		flex-grow: 1
	}
	
	.swal2-icon.swal2-error [class^=swal2-x-mark-line] {
		display: block;
		position: absolute;
		top: 2.3125em;
		width: 2.9375em;
		height: .3125em;
		border-radius: .125em;
		background-color: #f27474
	}
	
	.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
		left: 1.0625em;
		transform: rotate(45deg)
	}
	
	.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
		right: 1em;
		transform: rotate(-45deg)
	}
	
	.swal2-icon.swal2-warning {
		border-color: #facea8;
		color: #f8bb86
	}
	
	.swal2-icon.swal2-info {
		border-color: #9de0f6;
		color: #3fc3ee
	}
	
	.swal2-icon.swal2-question {
		border-color: #c9dae1;
		color: #87adbd
	}
	
	.swal2-icon.swal2-success {
		border-color: #a5dc86
	}
	
	.swal2-icon.swal2-success [class^=swal2-success-circular-line] {
		position: absolute;
		width: 3.75em;
		height: 7.5em;
		transform: rotate(45deg);
		border-radius: 50%
	}
	
	.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left] {
		top: -.4375em;
		left: -2.0635em;
		transform: rotate(-45deg);
		transform-origin: 3.75em 3.75em;
		border-radius: 7.5em 0 0 7.5em
	}
	
	.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right] {
		top: -.6875em;
		left: 1.875em;
		transform: rotate(-45deg);
		transform-origin: 0 3.75em;
		border-radius: 0 7.5em 7.5em 0
	}
	
	.swal2-icon.swal2-success .swal2-success-ring {
		position: absolute;
		top: -.25em;
		left: -.25em;
		width: 100%;
		height: 100%;
		border: .25em solid rgba(165, 220, 134, .3);
		border-radius: 50%;
		z-index: 2;
		box-sizing: content-box
	}
	
	.swal2-icon.swal2-success .swal2-success-fix {
		position: absolute;
		top: .5em;
		left: 1.625em;
		width: .4375em;
		height: 5.625em;
		transform: rotate(-45deg);
		z-index: 1
	}
	
	.swal2-icon.swal2-success [class^=swal2-success-line] {
		display: block;
		position: absolute;
		height: .3125em;
		border-radius: .125em;
		background-color: #a5dc86;
		z-index: 2
	}
	
	.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip] {
		top: 2.875em;
		left: .875em;
		width: 1.5625em;
		transform: rotate(45deg)
	}
	
	.swal2-icon.swal2-success [class^=swal2-success-line][class$=long] {
		top: 2.375em;
		right: .5em;
		width: 2.9375em;
		transform: rotate(-45deg)
	}
	
	.swal2-progresssteps {
		align-items: center;
		margin: 0 0 1.25em;
		padding: 0;
		font-weight: 600
	}
	
	.swal2-progresssteps li {
		display: inline-block;
		position: relative
	}
	
	.swal2-progresssteps .swal2-progresscircle {
		width: 2em;
		height: 2em;
		border-radius: 2em;
		background: #3085d6;
		color: #fff;
		line-height: 2em;
		text-align: center;
		z-index: 20
	}
	
	.swal2-progresssteps .swal2-progresscircle:first-child {
		margin-left: 0
	}
	
	.swal2-progresssteps .swal2-progresscircle:last-child {
		margin-right: 0
	}
	
	.swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep {
		background: #3085d6
	}
	
	.swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep~.swal2-progresscircle {
		background: #add8e6
	}
	
	.swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep~.swal2-progressline {
		background: #add8e6
	}
	
	.swal2-progresssteps .swal2-progressline {
		width: 2.5em;
		height: .4em;
		margin: 0 -1px;
		background: #3085d6;
		z-index: 10
	}
	
	[class^=swal2] {
		-webkit-tap-highlight-color: transparent
	}
	
	.swal2-show {
		-webkit-animation: swal2-show .3s;
		animation: swal2-show .3s
	}
	
	.swal2-show.swal2-noanimation {
		-webkit-animation: none;
		animation: none
	}
	
	.swal2-hide {
		-webkit-animation: swal2-hide .15s forwards;
		animation: swal2-hide .15s forwards
	}
	
	.swal2-hide.swal2-noanimation {
		-webkit-animation: none;
		animation: none
	}
	
	.swal2-rtl .swal2-close {
		right: auto;
		left: 0
	}
	
	.swal2-animate-success-icon .swal2-success-line-tip {
		-webkit-animation: swal2-animate-success-line-tip .75s;
		animation: swal2-animate-success-line-tip .75s
	}
	
	.swal2-animate-success-icon .swal2-success-line-long {
		-webkit-animation: swal2-animate-success-line-long .75s;
		animation: swal2-animate-success-line-long .75s
	}
	
	.swal2-animate-success-icon .swal2-success-circular-line-right {
		-webkit-animation: swal2-rotate-success-circular-line 4.25s ease-in;
		animation: swal2-rotate-success-circular-line 4.25s ease-in
	}
	
	.swal2-animate-error-icon {
		-webkit-animation: swal2-animate-error-icon .5s;
		animation: swal2-animate-error-icon .5s
	}
	
	.swal2-animate-error-icon .swal2-x-mark {
		-webkit-animation: swal2-animate-error-x-mark .5s;
		animation: swal2-animate-error-x-mark .5s
	}
	
	@-webkit-keyframes swal2-rotate-loading {
		0% {
			transform: rotate(0)
		}
		100% {
			transform: rotate(360deg)
		}
	}
	
	@keyframes swal2-rotate-loading {
		0% {
			transform: rotate(0)
		}
		100% {
			transform: rotate(360deg)
		}
	}
	
	@media print {
		body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
			overflow-y: scroll!important
		}
		body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true] {
			display: none
		}
		body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container {
			position: initial!important
		}
	}
	</style>
	<style type="text/css">
	.vue-stars {
		display: -webkit-inline-box;
		display: -ms-inline-flexbox;
		display: inline-flex;
		-webkit-box-orient: horizontal;
		-webkit-box-direction: normal;
		-ms-flex-flow: row nowrap;
		flex-flow: row nowrap;
		-webkit-box-align: flex-start center;
		-ms-flex-align: flex-start center;
		align-items: flex-start center;
		line-height: 1em
	}
	
	.vue-stars label {
		display: block;
		padding: .125em;
		width: 1.2em;
		text-align: center;
		color: #fd0;
		text-shadow: 0 0 .3em #ff0
	}
	
	.vue-stars.notouch:not(.readonly):hover label .inactive,
	.vue-stars.notouch:not(.readonly) label:hover~label .active,
	.vue-stars input,
	.vue-stars input:checked~label .active,
	.vue-stars label .inactive {
		display: none
	}
	
	.vue-stars.notouch:not(.readonly):hover label .active,
	.vue-stars.notouch:not(.readonly) label:hover~label .inactive,
	.vue-stars input:checked~label .inactive {
		display: inline
	}
	
	.vue-stars.notouch:not(.readonly):hover label {
		color: #dd0;
		text-shadow: 0 0 .3em #ff0
	}
	
	.vue-stars.notouch:not(.readonly) label:hover~label,
	.vue-stars input:checked~label {
		color: #999;
		text-shadow: none
	}
	
	@supports (color:var(--prop)) {
		.vue-stars label {
			color: var(--active-color, #fd0);
			text-shadow: 0 0 .2em var(--shadow-color, #ff0)
		}
		.vue-stars.notouch:not(.readonly):hover label {
			color: var(--hover-color, #dd0);
			text-shadow: 0 0 .2em var(--shadow-color, #ff0)
		}
		.vue-stars.notouch:not(.readonly) label:hover~label,
		.vue-stars input:checked~label {
			color: var(--inactive-color, #999)
		}
	}
	</style>
	<style type="text/css">
	.vbt-autcomplete-list[data-v-a0e87de4] {
		padding-top: 5px;
		position: absolute;
		max-height: 350px;
		overflow-y: auto;
		z-index: 999;
	}
	</style>
	<style type="text/css">
	.vue-map-container {
		position: relative;
	}
	
	.vue-map-container .vue-map {
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		position: absolute;
	}
	
	.vue-map-hidden {
		display: none;
	}
	</style>
	<style type="text/css">
	.vue-street-view-pano-container {
		position: relative;
	}
	
	.vue-street-view-pano-container .vue-street-view-pano {
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		position: absolute;
	}
	</style>
	<style type="text/css">
	.verte {
		position: relative;
		display: flex;
		justify-content: center;
	}
	
	.verte * {
		box-sizing: border-box;
	}
	
	.verte--loading {
		opacity: 0;
	}
	
	.verte__guide {
		width: 24px;
		height: 24px;
		padding: 0;
		border: 0;
		background: transparent;
	}
	
	.verte__guide:focus {
		outline: 0;
	}
	
	.verte__guide svg {
		width: 100%;
		height: 100%;
		fill: inherit;
	}
	
	.verte__menu {
		flex-direction: column;
		justify-content: center;
		align-items: stretch;
		width: 250px;
		border-radius: 6px;
		background-color: #fff;
		will-change: transform;
		box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
	}
	
	.verte__menu:focus {
		outline: none;
	}
	
	.verte__menu-origin {
		display: none;
		position: absolute;
		z-index: 10;
	}
	
	.verte__menu-origin--active {
		display: flex;
	}
	
	.verte__menu-origin--static {
		position: static;
		z-index: initial;
	}
	
	.verte__menu-origin--top {
		bottom: 50px;
	}
	
	.verte__menu-origin--bottom {
		top: 50px;
	}
	
	.verte__menu-origin--right {
		right: 0;
	}
	
	.verte__menu-origin--left {
		left: 0;
	}
	
	.verte__menu-origin--center {
		position: fixed;
		top: 0;
		left: 0;
		width: 100vw;
		height: 100vh;
		justify-content: center;
		align-items: center;
		background-color: rgba(0, 0, 0, 0.1);
	}
	
	.verte__menu-origin:focus {
		outline: none;
	}
	
	.verte__controller {
		padding: 0 20px 20px;
	}
	
	.verte__recent {
		display: flex;
		flex-wrap: wrap;
		justify-content: flex-end;
		align-items: center;
		width: 100%;
	}
	
	.verte__recent-color {
		margin: 4px;
		width: 27px;
		height: 27px;
		border-radius: 50%;
		background-color: #fff;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		background-image: linear-gradient(45deg, rgba(112, 128, 144, 0.5) 25%, transparent 25%), linear-gradient(45deg, transparent 75%, rgba(112, 128, 144, 0.5) 75%), linear-gradient(-45deg, rgba(112, 128, 144, 0.5) 25%, transparent 25%), linear-gradient(-45deg, transparent 75%, rgba(112, 128, 144, 0.5) 75%);
		background-size: 6px 6px;
		background-position: 0 0, 3px -3px, 0 3px, -3px 0px;
		overflow: hidden;
	}
	
	.verte__recent-color:after {
		content: '';
		display: block;
		width: 100%;
		height: 100%;
		background-color: currentColor;
	}
	
	.verte__value {
		padding: 0.6em;
		width: 100%;
		border: 1px solid #708090;
		border-radius: 6px 0 0 6px;
		text-align: center;
		font-size: 12px;
		-webkit-appearance: none;
		-moz-appearance: textfield;
	}
	
	.verte__value:focus {
		outline: none;
		border-color: #1a3aff;
	}
	
	.verte__icon {
		width: 20px;
		height: 20px;
	}
	
	.verte__icon--small {
		width: 12px;
		height: 12px;
	}
	
	.verte__input {
		padding: 5px;
		margin: 0 3px;
		min-width: 0;
		text-align: center;
		border-width: 0 0 1px 0;
		-webkit-appearance: none;
		appearance: none;
		-moz-appearance: textfield;
	}
	
	.verte__input::-webkit-inner-spin-button,
	.verte__input::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
	
	.verte__inputs {
		display: flex;
		font-size: 16px;
		margin-bottom: 5px;
	}
	
	.verte__draggable {
		border-radius: 6px 6px 0 0;
		height: 8px;
		width: 100%;
		cursor: -webkit-grab;
		cursor: grab;
		background: linear-gradient(90deg, #fff 2px, transparent 1%) center, linear-gradient(#fff 2px, transparent 1%) center, rgba(112, 128, 144, 0.2);
		background-size: 4px 4px;
	}
	
	.verte__model,
	.verte__submit {
		position: relative;
		display: inline-flex;
		justify-content: center;
		align-items: center;
		padding: 1px;
		border: 0;
		text-align: center;
		cursor: pointer;
		background-color: transparent;
		font-weight: 700;
		color: #708090;
		fill: #708090;
		outline: none;
	}
	
	.verte__model:hover,
	.verte__submit:hover {
		fill: #1a3aff;
		color: #1a3aff;
	}
	
	.verte__close {
		position: absolute;
		top: 1px;
		right: 1px;
		z-index: 1;
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 4px;
		cursor: pointer;
		border-radius: 50%;
		border: 0;
		transform: translate(50%, -50%);
		background-color: rgba(0, 0, 0, 0.4);
		fill: #fff;
		outline: none;
		box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
	}
	
	.verte__close:hover {
		background-color: rgba(0, 0, 0, 0.6);
	}
	
	.verte-picker {
		width: 100%;
		margin: 0 auto 10px;
		display: flex;
		flex-direction: column;
	}
	
	.verte-picker--wheel {
		margin-top: 20px;
	}
	
	.verte-picker__origin {
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		position: relative;
		margin: 0 auto;
		overflow: hidden;
	}
	
	.verte-picker__slider {
		margin: 20px 20px 0;
	}
	
	.verte-picker__canvas {
		display: block;
	}
	
	.verte-picker__cursor {
		position: absolute;
		top: 0;
		left: 0;
		margin: -6px;
		width: 12px;
		height: 12px;
		border: 1px solid #fff;
		border-radius: 50%;
		will-change: transform;
		pointer-events: none;
		background-color: transparent;
		box-shadow: #fff 0px 0px 0px 1.5px, rgba(0, 0, 0, 0.3) 0px 0px 1px 1px inset, rgba(0, 0, 0, 0.4) 0px 0px 1px 2px;
	}
	
	.verte-picker__input {
		display: flex;
		margin-bottom: 10px;
	}
	
	.slider {
		position: relative;
		display: flex;
		align-items: center;
		box-sizing: border-box;
		margin-bottom: 10px;
		font-size: 20px;
	}
	
	.slider:hover .slider-label,
	.slider--dragging .slider-label {
		visibility: visible;
		opacity: 1;
	}
	
	.slider__input {
		margin-bottom: 0;
		padding: 0.3em;
		margin-left: 0.2em;
		max-width: 70px;
		width: 20%;
		border: 0;
		text-align: center;
		font-size: 12px;
		-webkit-appearance: none;
		-moz-appearance: textfield;
	}
	
	.slider__input::-webkit-inner-spin-button,
	.slider__input::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
	
	.slider__input:focus {
		outline: none;
		border-color: #1a3aff;
	}
	
	.slider__track {
		position: relative;
		flex: 1;
		margin: 3px;
		width: auto;
		height: 8px;
		background: #fff;
		will-change: transfom;
		background-image: linear-gradient(45deg, rgba(112, 128, 144, 0.5) 25%, transparent 25%), linear-gradient(45deg, transparent 75%, rgba(112, 128, 144, 0.5) 75%), linear-gradient(-45deg, rgba(112, 128, 144, 0.5) 25%, transparent 25%), linear-gradient(-45deg, transparent 75%, rgba(112, 128, 144, 0.5) 75%);
		background-size: 6px 6px;
		background-position: 0 0, 3px -3px, 0 3px, -3px 0px;
		border-radius: 10px;
	}
	
	.slider__handle {
		position: relative;
		position: absolute;
		top: 0;
		left: 0;
		will-change: transform;
		color: #000;
		margin: -2px 0 0 -8px;
		width: 12px;
		height: 12px;
		border: 2px solid #fff;
		background-color: currentColor;
		border-radius: 50%;
		box-shadow: 0 1px 4px -2px black;
	}
	
	.slider__label {
		position: absolute;
		top: -3em;
		left: 0.4em;
		z-index: 999;
		visibility: hidden;
		padding: 6px;
		min-width: 3em;
		border-radius: 6px;
		background-color: #000;
		color: #fff;
		text-align: center;
		font-size: 12px;
		line-height: 1em;
		opacity: 0;
		transform: translate(-50%, 0);
		white-space: nowrap;
	}
	
	.slider__label:before {
		position: absolute;
		bottom: -0.6em;
		left: 50%;
		display: block;
		width: 0;
		height: 0;
		border-width: 0.6em 0.6em 0 0.6em;
		border-style: solid;
		border-color: #000 transparent transparent transparent;
		content: '';
		transform: translate3d(-50%, 0, 0);
	}
	
	.slider__fill {
		width: 100%;
		height: 100%;
		transform-origin: left top;
		border-radius: 10px;
	}
	</style>
	<style type="text/css">
	/*
 * The MIT License
 * Copyright (c) 2012 Matias Meno <m@tias.me>
 */
	
	@-webkit-keyframes passing-through {
		0% {
			opacity: 0;
			-webkit-transform: translateY(40px);
			-moz-transform: translateY(40px);
			-ms-transform: translateY(40px);
			-o-transform: translateY(40px);
			transform: translateY(40px);
		}
		30%,
		70% {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			-o-transform: translateY(0px);
			transform: translateY(0px);
		}
		100% {
			opacity: 0;
			-webkit-transform: translateY(-40px);
			-moz-transform: translateY(-40px);
			-ms-transform: translateY(-40px);
			-o-transform: translateY(-40px);
			transform: translateY(-40px);
		}
	}
	
	@-moz-keyframes passing-through {
		0% {
			opacity: 0;
			-webkit-transform: translateY(40px);
			-moz-transform: translateY(40px);
			-ms-transform: translateY(40px);
			-o-transform: translateY(40px);
			transform: translateY(40px);
		}
		30%,
		70% {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			-o-transform: translateY(0px);
			transform: translateY(0px);
		}
		100% {
			opacity: 0;
			-webkit-transform: translateY(-40px);
			-moz-transform: translateY(-40px);
			-ms-transform: translateY(-40px);
			-o-transform: translateY(-40px);
			transform: translateY(-40px);
		}
	}
	
	@keyframes passing-through {
		0% {
			opacity: 0;
			-webkit-transform: translateY(40px);
			-moz-transform: translateY(40px);
			-ms-transform: translateY(40px);
			-o-transform: translateY(40px);
			transform: translateY(40px);
		}
		30%,
		70% {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			-o-transform: translateY(0px);
			transform: translateY(0px);
		}
		100% {
			opacity: 0;
			-webkit-transform: translateY(-40px);
			-moz-transform: translateY(-40px);
			-ms-transform: translateY(-40px);
			-o-transform: translateY(-40px);
			transform: translateY(-40px);
		}
	}
	
	@-webkit-keyframes slide-in {
		0% {
			opacity: 0;
			-webkit-transform: translateY(40px);
			-moz-transform: translateY(40px);
			-ms-transform: translateY(40px);
			-o-transform: translateY(40px);
			transform: translateY(40px);
		}
		30% {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			-o-transform: translateY(0px);
			transform: translateY(0px);
		}
	}
	
	@-moz-keyframes slide-in {
		0% {
			opacity: 0;
			-webkit-transform: translateY(40px);
			-moz-transform: translateY(40px);
			-ms-transform: translateY(40px);
			-o-transform: translateY(40px);
			transform: translateY(40px);
		}
		30% {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			-o-transform: translateY(0px);
			transform: translateY(0px);
		}
	}
	
	@keyframes slide-in {
		0% {
			opacity: 0;
			-webkit-transform: translateY(40px);
			-moz-transform: translateY(40px);
			-ms-transform: translateY(40px);
			-o-transform: translateY(40px);
			transform: translateY(40px);
		}
		30% {
			opacity: 1;
			-webkit-transform: translateY(0px);
			-moz-transform: translateY(0px);
			-ms-transform: translateY(0px);
			-o-transform: translateY(0px);
			transform: translateY(0px);
		}
	}
	
	@-webkit-keyframes pulse {
		0% {
			-webkit-transform: scale(1);
			-moz-transform: scale(1);
			-ms-transform: scale(1);
			-o-transform: scale(1);
			transform: scale(1);
		}
		10% {
			-webkit-transform: scale(1.1);
			-moz-transform: scale(1.1);
			-ms-transform: scale(1.1);
			-o-transform: scale(1.1);
			transform: scale(1.1);
		}
		20% {
			-webkit-transform: scale(1);
			-moz-transform: scale(1);
			-ms-transform: scale(1);
			-o-transform: scale(1);
			transform: scale(1);
		}
	}
	
	@-moz-keyframes pulse {
		0% {
			-webkit-transform: scale(1);
			-moz-transform: scale(1);
			-ms-transform: scale(1);
			-o-transform: scale(1);
			transform: scale(1);
		}
		10% {
			-webkit-transform: scale(1.1);
			-moz-transform: scale(1.1);
			-ms-transform: scale(1.1);
			-o-transform: scale(1.1);
			transform: scale(1.1);
		}
		20% {
			-webkit-transform: scale(1);
			-moz-transform: scale(1);
			-ms-transform: scale(1);
			-o-transform: scale(1);
			transform: scale(1);
		}
	}
	
	@keyframes pulse {
		0% {
			-webkit-transform: scale(1);
			-moz-transform: scale(1);
			-ms-transform: scale(1);
			-o-transform: scale(1);
			transform: scale(1);
		}
		10% {
			-webkit-transform: scale(1.1);
			-moz-transform: scale(1.1);
			-ms-transform: scale(1.1);
			-o-transform: scale(1.1);
			transform: scale(1.1);
		}
		20% {
			-webkit-transform: scale(1);
			-moz-transform: scale(1);
			-ms-transform: scale(1);
			-o-transform: scale(1);
			transform: scale(1);
		}
	}
	
	.dropzone,
	.dropzone * {
		box-sizing: border-box;
	}
	
	.dropzone {
		min-height: 150px;
		border: 2px solid rgba(0, 0, 0, 0.3);
		background: white;
		padding: 20px 20px;
	}
	
	.dropzone.dz-clickable {
		cursor: pointer;
	}
	
	.dropzone.dz-clickable * {
		cursor: default;
	}
	
	.dropzone.dz-clickable .dz-message,
	.dropzone.dz-clickable .dz-message * {
		cursor: pointer;
	}
	
	.dropzone.dz-started .dz-message {
		display: none;
	}
	
	.dropzone.dz-drag-hover {
		border-style: solid;
	}
	
	.dropzone.dz-drag-hover .dz-message {
		opacity: 0.5;
	}
	
	.dropzone .dz-message {
		text-align: center;
		margin: 2em 0;
	}
	
	.dropzone .dz-preview {
		position: relative;
		display: inline-block;
		vertical-align: top;
		margin: 16px;
		min-height: 100px;
	}
	
	.dropzone .dz-preview:hover {
		z-index: 1000;
	}
	
	.dropzone .dz-preview:hover .dz-details {
		opacity: 1;
	}
	
	.dropzone .dz-preview.dz-file-preview .dz-image {
		border-radius: 20px;
		background: #999;
		background: linear-gradient(to bottom, #eee, #ddd);
	}
	
	.dropzone .dz-preview.dz-file-preview .dz-details {
		opacity: 1;
	}
	
	.dropzone .dz-preview.dz-image-preview {
		background: white;
	}
	
	.dropzone .dz-preview.dz-image-preview .dz-details {
		-webkit-transition: opacity 0.2s linear;
		-moz-transition: opacity 0.2s linear;
		-ms-transition: opacity 0.2s linear;
		-o-transition: opacity 0.2s linear;
		transition: opacity 0.2s linear;
	}
	
	.dropzone .dz-preview .dz-remove {
		font-size: 14px;
		text-align: center;
		display: block;
		cursor: pointer;
		border: none;
	}
	
	.dropzone .dz-preview .dz-remove:hover {
		text-decoration: underline;
	}
	
	.dropzone .dz-preview:hover .dz-details {
		opacity: 1;
	}
	
	.dropzone .dz-preview .dz-details {
		z-index: 20;
		position: absolute;
		top: 0;
		left: 0;
		opacity: 0;
		font-size: 13px;
		min-width: 100%;
		max-width: 100%;
		padding: 2em 1em;
		text-align: center;
		color: rgba(0, 0, 0, 0.9);
		line-height: 150%;
	}
	
	.dropzone .dz-preview .dz-details .dz-size {
		margin-bottom: 1em;
		font-size: 16px;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename {
		white-space: nowrap;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename:hover span {
		border: 1px solid rgba(200, 200, 200, 0.8);
		background-color: rgba(255, 255, 255, 0.8);
	}
	
	.dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
		overflow: hidden;
		text-overflow: ellipsis;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename:not(:hover) span {
		border: 1px solid transparent;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename span,
	.dropzone .dz-preview .dz-details .dz-size span {
		background-color: rgba(255, 255, 255, 0.4);
		padding: 0 0.4em;
		border-radius: 3px;
	}
	
	.dropzone .dz-preview:hover .dz-image img {
		-webkit-transform: scale(1.05, 1.05);
		-moz-transform: scale(1.05, 1.05);
		-ms-transform: scale(1.05, 1.05);
		-o-transform: scale(1.05, 1.05);
		transform: scale(1.05, 1.05);
		-webkit-filter: blur(8px);
		filter: blur(8px);
	}
	
	.dropzone .dz-preview .dz-image {
		border-radius: 20px;
		overflow: hidden;
		width: 120px;
		height: 120px;
		position: relative;
		display: block;
		z-index: 10;
	}
	
	.dropzone .dz-preview .dz-image img {
		display: block;
	}
	
	.dropzone .dz-preview.dz-success .dz-success-mark {
		-webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
		-moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
		-ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
		-o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
		animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
	}
	
	.dropzone .dz-preview.dz-error .dz-error-mark {
		opacity: 1;
		-webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
		-moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
		-ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
		-o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
		animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
	}
	
	.dropzone .dz-preview .dz-success-mark,
	.dropzone .dz-preview .dz-error-mark {
		pointer-events: none;
		opacity: 0;
		z-index: 500;
		position: absolute;
		display: block;
		top: 50%;
		left: 50%;
		margin-left: -27px;
		margin-top: -27px;
	}
	
	.dropzone .dz-preview .dz-success-mark svg,
	.dropzone .dz-preview .dz-error-mark svg {
		display: block;
		width: 54px;
		height: 54px;
	}
	
	.dropzone .dz-preview.dz-processing .dz-progress {
		opacity: 1;
		-webkit-transition: all 0.2s linear;
		-moz-transition: all 0.2s linear;
		-ms-transition: all 0.2s linear;
		-o-transition: all 0.2s linear;
		transition: all 0.2s linear;
	}
	
	.dropzone .dz-preview.dz-complete .dz-progress {
		opacity: 0;
		-webkit-transition: opacity 0.4s ease-in;
		-moz-transition: opacity 0.4s ease-in;
		-ms-transition: opacity 0.4s ease-in;
		-o-transition: opacity 0.4s ease-in;
		transition: opacity 0.4s ease-in;
	}
	
	.dropzone .dz-preview:not(.dz-processing) .dz-progress {
		-webkit-animation: pulse 6s ease infinite;
		-moz-animation: pulse 6s ease infinite;
		-ms-animation: pulse 6s ease infinite;
		-o-animation: pulse 6s ease infinite;
		animation: pulse 6s ease infinite;
	}
	
	.dropzone .dz-preview .dz-progress {
		opacity: 1;
		z-index: 1000;
		pointer-events: none;
		position: absolute;
		height: 16px;
		left: 50%;
		top: 50%;
		margin-top: -8px;
		width: 80px;
		margin-left: -40px;
		background: rgba(255, 255, 255, 0.9);
		-webkit-transform: scale(1);
		border-radius: 8px;
		overflow: hidden;
	}
	
	.dropzone .dz-preview .dz-progress .dz-upload {
		background: #333;
		background: linear-gradient(to bottom, #666, #444);
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		width: 0;
		-webkit-transition: width 300ms ease-in-out;
		-moz-transition: width 300ms ease-in-out;
		-ms-transition: width 300ms ease-in-out;
		-o-transition: width 300ms ease-in-out;
		transition: width 300ms ease-in-out;
	}
	
	.dropzone .dz-preview.dz-error .dz-error-message {
		display: block;
	}
	
	.dropzone .dz-preview.dz-error:hover .dz-error-message {
		opacity: 1;
		pointer-events: auto;
	}
	
	.dropzone .dz-preview .dz-error-message {
		pointer-events: none;
		z-index: 1000;
		position: absolute;
		display: block;
		display: none;
		opacity: 0;
		-webkit-transition: opacity 0.3s ease;
		-moz-transition: opacity 0.3s ease;
		-ms-transition: opacity 0.3s ease;
		-o-transition: opacity 0.3s ease;
		transition: opacity 0.3s ease;
		border-radius: 8px;
		font-size: 13px;
		top: 130px;
		left: -10px;
		width: 140px;
		background: #be2626;
		background: linear-gradient(to bottom, #be2626, #a92222);
		padding: 0.5em 1.2em;
		color: white;
	}
	
	.dropzone .dz-preview .dz-error-message:after {
		content: '';
		position: absolute;
		top: -6px;
		left: 64px;
		width: 0;
		height: 0;
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		border-bottom: 6px solid #be2626;
	}
	
	.vue-dropzone {
		border: 2px solid #e5e5e5;
		font-family: Arial, sans-serif;
		letter-spacing: .2px;
		color: #777;
		transition: .2s linear
	}
	
	.vue-dropzone:hover {
		background-color: #f6f6f6
	}
	
	.vue-dropzone>i {
		color: #ccc
	}
	
	.vue-dropzone>.dz-preview .dz-image {
		border-radius: 0;
		width: 100%;
		height: 100%
	}
	
	.vue-dropzone>.dz-preview .dz-image img:not([src]) {
		width: 200px;
		height: 200px
	}
	
	.vue-dropzone>.dz-preview .dz-image:hover img {
		transform: none;
		-webkit-filter: none
	}
	
	.vue-dropzone>.dz-preview .dz-details {
		bottom: 0;
		top: 0;
		color: #fff;
		background-color: rgba(33, 150, 243, .8);
		transition: opacity .2s linear;
		text-align: left
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename {
		overflow: hidden
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename span,
	.vue-dropzone>.dz-preview .dz-details .dz-size span {
		background-color: transparent
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename:not(:hover) span {
		border: none
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename:hover span {
		background-color: transparent;
		border: none
	}
	
	.vue-dropzone>.dz-preview .dz-progress .dz-upload {
		background: #ccc
	}
	
	.vue-dropzone>.dz-preview .dz-remove {
		position: absolute;
		z-index: 30;
		color: #fff;
		margin-left: 15px;
		padding: 10px;
		top: inherit;
		bottom: 15px;
		border: 2px #fff solid;
		text-decoration: none;
		text-transform: uppercase;
		font-size: .8rem;
		font-weight: 800;
		letter-spacing: 1.1px;
		opacity: 0
	}
	
	.vue-dropzone>.dz-preview:hover .dz-remove {
		opacity: 1
	}
	
	.vue-dropzone>.dz-preview .dz-error-mark,
	.vue-dropzone>.dz-preview .dz-success-mark {
		margin-left: auto;
		margin-top: auto;
		width: 100%;
		top: 35%;
		left: 0
	}
	
	.vue-dropzone>.dz-preview .dz-error-mark svg,
	.vue-dropzone>.dz-preview .dz-success-mark svg {
		margin-left: auto;
		margin-right: auto
	}
	
	.vue-dropzone>.dz-preview .dz-error-message {
		margin-left: auto;
		margin-right: auto;
		left: 0;
		width: 100%;
		text-align: center
	}
	
	.vue-dropzone>.dz-preview .dz-error-message:after {
		display: none
	}
	</style>
	<style type="text/css">

	</style>
	<style type="text/css">
	.fade-enter {
		opacity: 0;
	}
	
	.fade-enter-active {
		transition: opacity 1s;
	}
	
	.fade-leave-active {
		transition: opacity 1s;
		opacity: 0;
	}
	</style>
	<style type="text/css">
	.switch-button-control {
		display: flex;
		flex-direction: row;
		align-items: center;
	}
	
	.switch-button-control .switch-button {
		margin: 0;
		width: 35px;
		height: 21px;
		display: block;
		border-radius: 13px;
		transition: all 0.3s;
		box-shadow: inset 0 0 0 2px #e4e4e4;
		transition: all 0.4s;
		-webkit-transition: all 0.4s;
		cursor: pointer;
	}
	
	.switch-button-control .switch-button .button {
		left: 0;
		top: 1px;
		width: 18px;
		height: 18px;
		background: #fff;
		border-radius: 60px;
		border: 1px solid #e2e2e2;
		display: inline-block;
		position: relative;
		pointer-events: none;
		transition: all 0.3s ease 0s;
		box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.40);
	}
	
	.switch-button-control .switch-button.enabled {
		background-color: #26de81;
		box-shadow: none;
	}
	
	.switch-button-control .switch-button.enabled .button {
		background: white;
		transform: translateX(calc(calc( 1.6em - (2 * 2px)) + (2 *-1px)));
	}
	
	.switch-button-control .switch-button-label {
		margin-left: 10px;
	}
	</style>
	<style type="text/css">
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.3s;
	}
	
	.fade-enter,
	.fade-leave-to {
		opacity: 0;
	}
	</style>
	<style type="text/css">
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.3s;
	}
	
	.fade-enter,
	.fade-leave-to {
		opacity: 0;
	}
	</style>
	<style type="text/css">

	</style>
	<style type="text/css">

	</style>
	<style type="text/css">

	</style>
	<style type="text/css">

	</style>
	<style type="text/css">
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.3s;
	}
	
	.fade-enter,
	.fade-leave-to {
		opacity: 0;
	}
	</style>
	<style type="text/css">
	.fade-enter {
		opacity: 0;
	}
	
	.fade-enter-active {
		transition: opacity 1s;
	}
	
	.fade-leave-active {
		transition: opacity 1s;
		opacity: 0;
	}
	</style>
	<style type="text/css">
	.wt-radioholder {
		transition: 1s;
	}
	</style>
	<style type="text/css">
	.users {
		background-color: #fff;
		border-radius: 3px;
	}
	</style>
	<style type="text/css">
	.wt-custom-scrollbar-wrapper {
		height: 652px;
	}
	</style>
	<style type="text/css">

	</style>
	<style type="text/css">
	/*
 * The MIT License
 * Copyright (c) 2012 Matias Meno <m@tias.me>
 */
	
	@-webkit-keyframes passing-through {
		0% {
			opacity: 0;
			transform: translateY(40px);
		}
		30%,
		70% {
			opacity: 1;
			transform: translateY(0px);
		}
		100% {
			opacity: 0;
			transform: translateY(-40px);
		}
	}
	
	@keyframes passing-through {
		0% {
			opacity: 0;
			transform: translateY(40px);
		}
		30%,
		70% {
			opacity: 1;
			transform: translateY(0px);
		}
		100% {
			opacity: 0;
			transform: translateY(-40px);
		}
	}
	
	@-webkit-keyframes slide-in {
		0% {
			opacity: 0;
			transform: translateY(40px);
		}
		30% {
			opacity: 1;
			transform: translateY(0px);
		}
	}
	
	@keyframes slide-in {
		0% {
			opacity: 0;
			transform: translateY(40px);
		}
		30% {
			opacity: 1;
			transform: translateY(0px);
		}
	}
	
	@-webkit-keyframes pulse {
		0% {
			transform: scale(1);
		}
		10% {
			transform: scale(1.1);
		}
		20% {
			transform: scale(1);
		}
	}
	
	@keyframes pulse {
		0% {
			transform: scale(1);
		}
		10% {
			transform: scale(1.1);
		}
		20% {
			transform: scale(1);
		}
	}
	
	.dropzone,
	.dropzone * {
		box-sizing: border-box;
	}
	
	.dropzone {
		min-height: 150px;
		border: 2px solid rgba(0, 0, 0, 0.3);
		background: white;
		padding: 20px 20px;
	}
	
	.dropzone.dz-clickable {
		cursor: pointer;
	}
	
	.dropzone.dz-clickable * {
		cursor: default;
	}
	
	.dropzone.dz-clickable .dz-message,
	.dropzone.dz-clickable .dz-message * {
		cursor: pointer;
	}
	
	.dropzone.dz-started .dz-message {
		display: none;
	}
	
	.dropzone.dz-drag-hover {
		border-style: solid;
	}
	
	.dropzone.dz-drag-hover .dz-message {
		opacity: 0.5;
	}
	
	.dropzone .dz-message {
		text-align: center;
		margin: 2em 0;
	}
	
	.dropzone .dz-preview {
		position: relative;
		display: inline-block;
		vertical-align: top;
		margin: 16px;
		min-height: 100px;
	}
	
	.dropzone .dz-preview:hover {
		z-index: 1000;
	}
	
	.dropzone .dz-preview:hover .dz-details {
		opacity: 1;
	}
	
	.dropzone .dz-preview.dz-file-preview .dz-image {
		border-radius: 20px;
		background: #999;
		background: linear-gradient(to bottom, #eee, #ddd);
	}
	
	.dropzone .dz-preview.dz-file-preview .dz-details {
		opacity: 1;
	}
	
	.dropzone .dz-preview.dz-image-preview {
		background: white;
	}
	
	.dropzone .dz-preview.dz-image-preview .dz-details {
		transition: opacity 0.2s linear;
	}
	
	.dropzone .dz-preview .dz-remove {
		font-size: 14px;
		text-align: center;
		display: block;
		cursor: pointer;
		border: none;
	}
	
	.dropzone .dz-preview .dz-remove:hover {
		text-decoration: underline;
	}
	
	.dropzone .dz-preview:hover .dz-details {
		opacity: 1;
	}
	
	.dropzone .dz-preview .dz-details {
		z-index: 20;
		position: absolute;
		top: 0;
		left: 0;
		opacity: 0;
		font-size: 13px;
		min-width: 100%;
		max-width: 100%;
		padding: 2em 1em;
		text-align: center;
		color: rgba(0, 0, 0, 0.9);
		line-height: 150%;
	}
	
	.dropzone .dz-preview .dz-details .dz-size {
		margin-bottom: 1em;
		font-size: 16px;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename {
		white-space: nowrap;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename:hover span {
		border: 1px solid rgba(200, 200, 200, 0.8);
		background-color: rgba(255, 255, 255, 0.8);
	}
	
	.dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
		overflow: hidden;
		text-overflow: ellipsis;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename:not(:hover) span {
		border: 1px solid transparent;
	}
	
	.dropzone .dz-preview .dz-details .dz-filename span,
	.dropzone .dz-preview .dz-details .dz-size span {
		background-color: rgba(255, 255, 255, 0.4);
		padding: 0 0.4em;
		border-radius: 3px;
	}
	
	.dropzone .dz-preview:hover .dz-image img {
		transform: scale(1.05, 1.05);
		-webkit-filter: blur(8px);
		filter: blur(8px);
	}
	
	.dropzone .dz-preview .dz-image {
		border-radius: 20px;
		overflow: hidden;
		width: 120px;
		height: 120px;
		position: relative;
		display: block;
		z-index: 10;
	}
	
	.dropzone .dz-preview .dz-image img {
		display: block;
	}
	
	.dropzone .dz-preview.dz-success .dz-success-mark {
		-webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
		animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
	}
	
	.dropzone .dz-preview.dz-error .dz-error-mark {
		opacity: 1;
		-webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
		animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
	}
	
	.dropzone .dz-preview .dz-success-mark,
	.dropzone .dz-preview .dz-error-mark {
		pointer-events: none;
		opacity: 0;
		z-index: 500;
		position: absolute;
		display: block;
		top: 50%;
		left: 50%;
		margin-left: -27px;
		margin-top: -27px;
	}
	
	.dropzone .dz-preview .dz-success-mark svg,
	.dropzone .dz-preview .dz-error-mark svg {
		display: block;
		width: 54px;
		height: 54px;
	}
	
	.dropzone .dz-preview.dz-processing .dz-progress {
		opacity: 1;
		transition: all 0.2s linear;
	}
	
	.dropzone .dz-preview.dz-complete .dz-progress {
		opacity: 0;
		transition: opacity 0.4s ease-in;
	}
	
	.dropzone .dz-preview:not(.dz-processing) .dz-progress {
		-webkit-animation: pulse 6s ease infinite;
		animation: pulse 6s ease infinite;
	}
	
	.dropzone .dz-preview .dz-progress {
		opacity: 1;
		z-index: 1000;
		pointer-events: none;
		position: absolute;
		height: 16px;
		left: 50%;
		top: 50%;
		margin-top: -8px;
		width: 80px;
		margin-left: -40px;
		background: rgba(255, 255, 255, 0.9);
		-webkit-transform: scale(1);
		border-radius: 8px;
		overflow: hidden;
	}
	
	.dropzone .dz-preview .dz-progress .dz-upload {
		background: #333;
		background: linear-gradient(to bottom, #666, #444);
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		width: 0;
		transition: width 300ms ease-in-out;
	}
	
	.dropzone .dz-preview.dz-error .dz-error-message {
		display: block;
	}
	
	.dropzone .dz-preview.dz-error:hover .dz-error-message {
		opacity: 1;
		pointer-events: auto;
	}
	
	.dropzone .dz-preview .dz-error-message {
		pointer-events: none;
		z-index: 1000;
		position: absolute;
		display: block;
		display: none;
		opacity: 0;
		transition: opacity 0.3s ease;
		border-radius: 8px;
		font-size: 13px;
		top: 130px;
		left: -10px;
		width: 140px;
		background: #be2626;
		background: linear-gradient(to bottom, #be2626, #a92222);
		padding: 0.5em 1.2em;
		color: white;
	}
	
	.dropzone .dz-preview .dz-error-message:after {
		content: '';
		position: absolute;
		top: -6px;
		left: 64px;
		width: 0;
		height: 0;
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		border-bottom: 6px solid #be2626;
	}
	
	.vue-dropzone {
		border: 2px solid #e5e5e5;
		font-family: Arial, sans-serif;
		letter-spacing: .2px;
		color: #777;
		transition: .2s linear
	}
	
	.vue-dropzone:hover {
		background-color: #f6f6f6
	}
	
	.vue-dropzone>i {
		color: #ccc
	}
	
	.vue-dropzone>.dz-preview .dz-image {
		border-radius: 0;
		width: 100%;
		height: 100%
	}
	
	.vue-dropzone>.dz-preview .dz-image img:not([src]) {
		width: 200px;
		height: 200px
	}
	
	.vue-dropzone>.dz-preview .dz-image:hover img {
		transform: none;
		-webkit-filter: none
	}
	
	.vue-dropzone>.dz-preview .dz-details {
		bottom: 0;
		top: 0;
		color: #fff;
		background-color: rgba(33, 150, 243, .8);
		transition: opacity .2s linear;
		text-align: left
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename {
		overflow: hidden
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename span,
	.vue-dropzone>.dz-preview .dz-details .dz-size span {
		background-color: transparent
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename:not(:hover) span {
		border: none
	}
	
	.vue-dropzone>.dz-preview .dz-details .dz-filename:hover span {
		background-color: transparent;
		border: none
	}
	
	.vue-dropzone>.dz-preview .dz-progress .dz-upload {
		background: #ccc
	}
	
	.vue-dropzone>.dz-preview .dz-remove {
		position: absolute;
		z-index: 30;
		color: #fff;
		margin-left: 15px;
		padding: 10px;
		top: inherit;
		bottom: 15px;
		border: 2px #fff solid;
		text-decoration: none;
		text-transform: uppercase;
		font-size: .8rem;
		font-weight: 800;
		letter-spacing: 1.1px;
		opacity: 0
	}
	
	.vue-dropzone>.dz-preview:hover .dz-remove {
		opacity: 1
	}
	
	.vue-dropzone>.dz-preview .dz-error-mark,
	.vue-dropzone>.dz-preview .dz-success-mark {
		margin-left: auto;
		margin-top: auto;
		width: 100%;
		top: 35%;
		left: 0
	}
	
	.vue-dropzone>.dz-preview .dz-error-mark svg,
	.vue-dropzone>.dz-preview .dz-success-mark svg {
		margin-left: auto;
		margin-right: auto
	}
	
	.vue-dropzone>.dz-preview .dz-error-message {
		margin-left: auto;
		margin-right: auto;
		left: 0;
		width: 100%;
		text-align: center
	}
	
	.vue-dropzone>.dz-preview .dz-error-message:after {
		display: none
	}
	</style>
	<style type="text/css">
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.3s;
	}
	
	.fade-enter,
	.fade-leave-to {
		opacity: 0;
	}
	</style>
	<style type="text/css">
	/**
 * Owl Carousel v2.3.4
 * Copyright 2013-2018 David Deutsch
 * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
 */
	/*
 *  Owl Carousel - Core
 */
	
	.owl-carousel {
		display: none;
		width: 100%;
		-webkit-tap-highlight-color: transparent;
		/* position relative and z-index fix webkit rendering fonts issue */
		position: relative;
		z-index: 1;
	}
	
	.owl-carousel .owl-stage {
		position: relative;
		-ms-touch-action: pan-Y;
		touch-action: manipulation;
		-moz-backface-visibility: hidden;
		/* fix firefox animation glitch */
	}
	
	.owl-carousel .owl-stage:after {
		content: ".";
		display: block;
		clear: both;
		visibility: hidden;
		line-height: 0;
		height: 0;
	}
	
	.owl-carousel .owl-stage-outer {
		position: relative;
		overflow: hidden;
		/* fix for flashing background */
		-webkit-transform: translate3d(0px, 0px, 0px);
	}
	
	.owl-carousel .owl-wrapper,
	.owl-carousel .owl-item {
		-webkit-backface-visibility: hidden;
		-moz-backface-visibility: hidden;
		-ms-backface-visibility: hidden;
		-webkit-transform: translate3d(0, 0, 0);
		-moz-transform: translate3d(0, 0, 0);
		-ms-transform: translate3d(0, 0, 0);
	}
	
	.owl-carousel .owl-item {
		position: relative;
		min-height: 1px;
		float: left;
		-webkit-backface-visibility: hidden;
		-webkit-tap-highlight-color: transparent;
		-webkit-touch-callout: none;
	}
	
	.owl-carousel .owl-item img {
		display: block;
		width: 100%;
	}
	
	.owl-carousel .owl-nav.disabled,
	.owl-carousel .owl-dots.disabled {
		display: none;
	}
	
	.owl-carousel .owl-nav .owl-prev,
	.owl-carousel .owl-nav .owl-next,
	.owl-carousel .owl-dot {
		cursor: pointer;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	
	.owl-carousel .owl-nav button.owl-prev,
	.owl-carousel .owl-nav button.owl-next,
	.owl-carousel button.owl-dot {
		background: none;
		color: inherit;
		border: none;
		padding: 0 !important;
		font: inherit;
	}
	
	.owl-carousel.owl-loaded {
		display: block;
	}
	
	.owl-carousel.owl-loading {
		opacity: 0;
		display: block;
	}
	
	.owl-carousel.owl-hidden {
		opacity: 0;
	}
	
	.owl-carousel.owl-refresh .owl-item {
		visibility: hidden;
	}
	
	.owl-carousel.owl-drag .owl-item {
		-ms-touch-action: pan-y;
		touch-action: pan-y;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	
	.owl-carousel.owl-grab {
		cursor: move;
		cursor: grab;
	}
	
	.owl-carousel.owl-rtl {
		direction: rtl;
	}
	
	.owl-carousel.owl-rtl .owl-item {
		float: right;
	}
	/* No Js */
	
	.no-js .owl-carousel {
		display: block;
	}
	/*
 *  Owl Carousel - Animate Plugin
 */
	
	.owl-carousel .animated {
		animation-duration: 1000ms;
		animation-fill-mode: both;
	}
	
	.owl-carousel .owl-animated-in {
		z-index: 0;
	}
	
	.owl-carousel .owl-animated-out {
		z-index: 1;
	}
	
	.owl-carousel .fadeOut {
		animation-name: fadeOut;
	}
	
	@keyframes fadeOut {
		0% {
			opacity: 1;
		}
		100% {
			opacity: 0;
		}
	}
	/*
 * 	Owl Carousel - Auto Height Plugin
 */
	
	.owl-height {
		transition: height 500ms ease-in-out;
	}
	/*
 * 	Owl Carousel - Lazy Load Plugin
 */
	
	.owl-carousel .owl-item {
		/**
			This is introduced due to a bug in IE11 where lazy loading combined with autoheight plugin causes a wrong
			calculation of the height of the owl-item that breaks page layouts
		 */
	}
	
	.owl-carousel .owl-item .owl-lazy {
		opacity: 0;
		transition: opacity 400ms ease;
	}
	
	.owl-carousel .owl-item .owl-lazy[src^=""],
	.owl-carousel .owl-item .owl-lazy:not([src]) {
		max-height: 0;
	}
	
	.owl-carousel .owl-item img.owl-lazy {
		transform-style: preserve-3d;
	}
	/*
 * 	Owl Carousel - Video Plugin
 */
	
	.owl-carousel .owl-video-wrapper {
		position: relative;
		height: 100%;
		background: #000;
	}
	
	.owl-carousel .owl-video-play-icon {
		position: absolute;
		height: 80px;
		width: 80px;
		left: 50%;
		top: 50%;
		margin-left: -40px;
		margin-top: -40px;
		background: url(4a37f8008959c75f619bf0a3a4e2d7a2.png) no-repeat;
		cursor: pointer;
		z-index: 1;
		-webkit-backface-visibility: hidden;
		transition: transform 100ms ease;
	}
	
	.owl-carousel .owl-video-play-icon:hover {
		-ms-transform: scale(1.3, 1.3);
		transform: scale(1.3, 1.3);
	}
	
	.owl-carousel .owl-video-playing .owl-video-tn,
	.owl-carousel .owl-video-playing .owl-video-play-icon {
		display: none;
	}
	
	.owl-carousel .owl-video-tn {
		opacity: 0;
		height: 100%;
		background-position: center center;
		background-repeat: no-repeat;
		background-size: contain;
		transition: opacity 400ms ease;
	}
	
	.owl-carousel .owl-video-frame {
		position: relative;
		z-index: 1;
		height: 100%;
		width: 100%;
	}
	</style>
	<style type="text/css">
	/**
 * Owl Carousel v2.3.4
 * Copyright 2013-2018 David Deutsch
 * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
 */
	/*
 * 	Default theme - Owl Carousel CSS File
 */
	
	.owl-theme .owl-nav {
		margin-top: 10px;
		text-align: center;
		-webkit-tap-highlight-color: transparent;
	}
	
	.owl-theme .owl-nav [class*='owl-'] {
		color: #FFF;
		font-size: 14px;
		margin: 5px;
		padding: 4px 7px;
		background: #D6D6D6;
		display: inline-block;
		cursor: pointer;
		border-radius: 3px;
	}
	
	.owl-theme .owl-nav [class*='owl-']:hover {
		background: #869791;
		color: #FFF;
		text-decoration: none;
	}
	
	.owl-theme .owl-nav .disabled {
		opacity: 0.5;
		cursor: default;
	}
	
	.owl-theme .owl-nav.disabled + .owl-dots {
		margin-top: 10px;
	}
	
	.owl-theme .owl-dots {
		text-align: center;
		-webkit-tap-highlight-color: transparent;
	}
	
	.owl-theme .owl-dots .owl-dot {
		display: inline-block;
		zoom: 1;
		*display: inline;
	}
	
	.owl-theme .owl-dots .owl-dot span {
		width: 10px;
		height: 10px;
		margin: 5px 7px;
		background: #D6D6D6;
		display: block;
		-webkit-backface-visibility: visible;
		transition: opacity 200ms ease;
		border-radius: 30px;
	}
	
	.owl-theme .owl-dots .owl-dot.active span,
	.owl-theme .owl-dots .owl-dot:hover span {
		background: #869791;
	}
	</style>
	<style type="text/css">
	.flip-list-move {
		transition: transform 0.5s;
	}
	
	.no-move {
		transition: transform 0s;
	}
	</style>
	<style type="text/css">
	.flip-list-move {
		transition: transform 0.5s;
	}
	
	.no-move {
		transition: transform 0s;
	}
	</style>
	<style type="text/css">
	/* stylelint-disable at-rule-empty-line-before,at-rule-name-space-after,at-rule-no-unknown */
	/* stylelint-disable no-duplicate-selectors */
	/* stylelint-disable */
	/* stylelint-disable declaration-bang-space-before,no-duplicate-selectors,string-no-newline */
	
	.ant-slider {
		box-sizing: border-box;
		margin: 0;
		padding: 0;
		color: rgba(0, 0, 0, 0.65);
		font-size: 14px;
		font-variant: tabular-nums;
		line-height: 1.5;
		list-style: none;
		font-feature-settings: 'tnum';
		position: relative;
		height: 12px;
		margin: 14px 6px 10px;
		padding: 4px 0;
		cursor: pointer;
		touch-action: none;
	}
	
	.ant-slider-vertical {
		width: 12px;
		height: 100%;
		margin: 6px 10px;
		padding: 0 4px;
	}
	
	.ant-slider-vertical .ant-slider-rail {
		width: 4px;
		height: 100%;
	}
	
	.ant-slider-vertical .ant-slider-track {
		width: 4px;
	}
	
	.ant-slider-vertical .ant-slider-handle {
		margin-bottom: -7px;
		margin-left: -5px;
	}
	
	.ant-slider-vertical .ant-slider-mark {
		top: 0;
		left: 12px;
		width: 18px;
		height: 100%;
	}
	
	.ant-slider-vertical .ant-slider-mark-text {
		left: 4px;
		white-space: nowrap;
	}
	
	.ant-slider-vertical .ant-slider-step {
		width: 4px;
		height: 100%;
	}
	
	.ant-slider-vertical .ant-slider-dot {
		top: auto;
		left: 2px;
		margin-bottom: -4px;
	}
	
	.ant-slider-with-marks {
		margin-bottom: 28px;
	}
	
	.ant-slider-rail {
		position: absolute;
		width: 100%;
		height: 4px;
		background-color: #f5f5f5;
		border-radius: 2px;
		transition: background-color 0.3s;
	}
	
	.ant-slider-track {
		position: absolute;
		height: 4px;
		background-color: #91d5ff;
		border-radius: 4px;
		transition: background-color 0.3s ease;
	}
	
	.ant-slider-handle {
		position: absolute;
		width: 14px;
		height: 14px;
		margin-top: -5px;
		margin-left: -7px;
		background-color: #fff;
		border: solid 2px #91d5ff;
		border-radius: 50%;
		box-shadow: 0;
		cursor: pointer;
		transition: border-color 0.3s, box-shadow 0.6s, transform 0.3s cubic-bezier(0.18, 0.89, 0.32, 1.28);
	}
	
	.ant-slider-handle:focus {
		border-color: #46a6ff;
		outline: none;
		box-shadow: 0 0 0 5px rgba(24, 144, 255, 0.2);
	}
	
	.ant-slider-handle.ant-tooltip-open {
		border-color: #1890ff;
	}
	
	.ant-slider:hover .ant-slider-rail {
		background-color: #e1e1e1;
	}
	
	.ant-slider:hover .ant-slider-track {
		background-color: #69c0ff;
	}
	
	.ant-slider:hover .ant-slider-handle:not(.ant-tooltip-open) {
		border-color: #69c0ff;
	}
	
	.ant-slider-mark {
		position: absolute;
		top: 14px;
		left: 0;
		width: 100%;
		font-size: 14px;
	}
	
	.ant-slider-mark-text {
		position: absolute;
		display: inline-block;
		color: rgba(0, 0, 0, 0.45);
		text-align: center;
		cursor: pointer;
	}
	
	.ant-slider-mark-text-active {
		color: rgba(0, 0, 0, 0.65);
	}
	
	.ant-slider-step {
		position: absolute;
		width: 100%;
		height: 4px;
		background: transparent;
	}
	
	.ant-slider-dot {
		position: absolute;
		top: -2px;
		width: 8px;
		height: 8px;
		margin-left: -4px;
		background-color: #fff;
		border: 2px solid #e8e8e8;
		border-radius: 50%;
		cursor: pointer;
	}
	
	.ant-slider-dot:first-child {
		margin-left: -4px;
	}
	
	.ant-slider-dot:last-child {
		margin-left: -4px;
	}
	
	.ant-slider-dot-active {
		border-color: #8cc8ff;
	}
	
	.ant-slider-disabled {
		cursor: not-allowed;
	}
	
	.ant-slider-disabled .ant-slider-track {
		background-color: rgba(0, 0, 0, 0.25) !important;
	}
	
	.ant-slider-disabled .ant-slider-handle,
	.ant-slider-disabled .ant-slider-dot {
		background-color: #fff;
		border-color: rgba(0, 0, 0, 0.25) !important;
		box-shadow: none;
		cursor: not-allowed;
	}
	
	.ant-slider-disabled .ant-slider-mark-text,
	.ant-slider-disabled .ant-slider-dot {
		cursor: not-allowed !important;
	}
	</style>
	<style type="text/css">
	/* stylelint-disable at-rule-empty-line-before,at-rule-name-space-after,at-rule-no-unknown */
	/* stylelint-disable no-duplicate-selectors */
	/* stylelint-disable */
	/* stylelint-disable declaration-bang-space-before,no-duplicate-selectors,string-no-newline */
	
	.ant-tooltip {
		box-sizing: border-box;
		margin: 0;
		padding: 0;
		color: rgba(0, 0, 0, 0.65);
		font-size: 14px;
		font-variant: tabular-nums;
		line-height: 1.5;
		list-style: none;
		font-feature-settings: 'tnum';
		position: absolute;
		z-index: 1060;
		display: block;
		max-width: 250px;
		visibility: visible;
	}
	
	.ant-tooltip-hidden {
		display: none;
	}
	
	.ant-tooltip-placement-top,
	.ant-tooltip-placement-topLeft,
	.ant-tooltip-placement-topRight {
		padding-bottom: 8px;
	}
	
	.ant-tooltip-placement-right,
	.ant-tooltip-placement-rightTop,
	.ant-tooltip-placement-rightBottom {
		padding-left: 8px;
	}
	
	.ant-tooltip-placement-bottom,
	.ant-tooltip-placement-bottomLeft,
	.ant-tooltip-placement-bottomRight {
		padding-top: 8px;
	}
	
	.ant-tooltip-placement-left,
	.ant-tooltip-placement-leftTop,
	.ant-tooltip-placement-leftBottom {
		padding-right: 8px;
	}
	
	.ant-tooltip-inner {
		min-width: 30px;
		min-height: 32px;
		padding: 6px 8px;
		color: #fff;
		text-align: left;
		text-decoration: none;
		word-wrap: break-word;
		background-color: rgba(0, 0, 0, 0.75);
		border-radius: 4px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
	}
	
	.ant-tooltip-arrow {
		position: absolute;
		width: 0;
		height: 0;
		border-style: solid;
		border-color: transparent;
	}
	
	.ant-tooltip-placement-top .ant-tooltip-arrow,
	.ant-tooltip-placement-topLeft .ant-tooltip-arrow,
	.ant-tooltip-placement-topRight .ant-tooltip-arrow {
		bottom: 3px;
		border-width: 5px 5px 0;
		border-top-color: rgba(0, 0, 0, 0.75);
	}
	
	.ant-tooltip-placement-top .ant-tooltip-arrow {
		left: 50%;
		margin-left: -5px;
	}
	
	.ant-tooltip-placement-topLeft .ant-tooltip-arrow {
		left: 16px;
	}
	
	.ant-tooltip-placement-topRight .ant-tooltip-arrow {
		right: 16px;
	}
	
	.ant-tooltip-placement-right .ant-tooltip-arrow,
	.ant-tooltip-placement-rightTop .ant-tooltip-arrow,
	.ant-tooltip-placement-rightBottom .ant-tooltip-arrow {
		left: 3px;
		border-width: 5px 5px 5px 0;
		border-right-color: rgba(0, 0, 0, 0.75);
	}
	
	.ant-tooltip-placement-right .ant-tooltip-arrow {
		top: 50%;
		margin-top: -5px;
	}
	
	.ant-tooltip-placement-rightTop .ant-tooltip-arrow {
		top: 8px;
	}
	
	.ant-tooltip-placement-rightBottom .ant-tooltip-arrow {
		bottom: 8px;
	}
	
	.ant-tooltip-placement-left .ant-tooltip-arrow,
	.ant-tooltip-placement-leftTop .ant-tooltip-arrow,
	.ant-tooltip-placement-leftBottom .ant-tooltip-arrow {
		right: 3px;
		border-width: 5px 0 5px 5px;
		border-left-color: rgba(0, 0, 0, 0.75);
	}
	
	.ant-tooltip-placement-left .ant-tooltip-arrow {
		top: 50%;
		margin-top: -5px;
	}
	
	.ant-tooltip-placement-leftTop .ant-tooltip-arrow {
		top: 8px;
	}
	
	.ant-tooltip-placement-leftBottom .ant-tooltip-arrow {
		bottom: 8px;
	}
	
	.ant-tooltip-placement-bottom .ant-tooltip-arrow,
	.ant-tooltip-placement-bottomLeft .ant-tooltip-arrow,
	.ant-tooltip-placement-bottomRight .ant-tooltip-arrow {
		top: 3px;
		border-width: 0 5px 5px;
		border-bottom-color: rgba(0, 0, 0, 0.75);
	}
	
	.ant-tooltip-placement-bottom .ant-tooltip-arrow {
		left: 50%;
		margin-left: -5px;
	}
	
	.ant-tooltip-placement-bottomLeft .ant-tooltip-arrow {
		left: 16px;
	}
	
	.ant-tooltip-placement-bottomRight .ant-tooltip-arrow {
		right: 16px;
	}
	</style>
	<style type="text/css">

	</style>
	<style type="text/css">
	.wt-radioholder {
		transition: 1s;
	}
	
	.ant-slider-track {
		height: 2px;
		background: var(--terthemecolor);
	}
	
	.ant-slider-rail {
		background: #ddd;
		height: 2px;
	}
	
	.ant-slider-step {
		height: 2px;
	}
	
	.ant-slider-handle {
		border: 2px solid var(--terthemecolor);
		width: 24px;
		height: 24px;
		margin-top: -11px;
	}
	
	.ant-slider-handle:focus {
		box-shadow: none;
		border-color: var(--terthemecolor);
	}
	
	.ant-slider:hover .ant-slider-track {
		background: var(--terthemecolor);
	}
	
	.ant-slider:hover .ant-slider-handle:not(.ant-tooltip-open) {
		border-color: var(--terthemecolor);
	}
	</style>
</head>

<body class="wt-login lang-en ltr ">
	<!--[if lt IE 8]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->
	<div class="preloader-outer" style="display: none;">
		<div class="preloader-holder">
			<div class="loader"></div>
		</div>
	</div>
	<div id="wt-wrapper" class="wt-wrapper wt-haslayout">
		<div class="wt-contentwrapper">
			@if (Schema::hasTable('pages') || Schema::hasTable('site_managements'))
        @php
            $settings = array();
            $pages = App\Page::all();
            $setting = \App\SiteManagement::getMetaValue('settings');
            $logo = !empty($setting[0]['logo']) ? Helper::getHeaderLogo($setting[0]['logo']) : '/images/logo.png';
            $inner_header = !empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' ? 'wt-headervtwo' : '';
            $type = Helper::getAccessType();
            $page_id='';
            if (!empty(Route::getCurrentRoute()) && Route::getCurrentRoute()->uri() != '/' && Route::getCurrentRoute()->uri() != 'home') {
                if (Request::segment(1) == 'page') {
                    $selected_page_data = APP\Page::getPageData(Request::segment(2));
                    $selected_page = !empty($selected_page_data) ? APP\Page::find($selected_page_data->id) : '';
                    $page_id = !empty($selected_page) ? $selected_page->id : '';
                }
            } else {
                $page_id = APP\SiteManagement::getMetaValue('homepage');
            }
            $slider = Helper::getPageSlider($page_id);
        @endphp
    @endif
			<header id="wt-header" class="wt-header wt-headereleven">
				<div class="wt-navigationarea">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><strong class="wt-logo" style="height:0px;"><a href="{{{ url('/') }}}"><!--<img src="{{{ asset($logo) }}}" alt="{{{ trans('Logo') }}}" style="height:30px;">--></a>
   <img src="http://dev.ebelong.com/uploads/settings/general/ebelong-logo-header.png" alt="{{{ trans('Logo') }}}" style="width:200px;">
							</strong>
								<div class="wt-rightarea">
									<nav id="wt-nav" class="wt-nav navbar-expand-lg">
										<button type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><i class="lnr lnr-menu"></i></button>
										<div id="navbarNav" class="collapse navbar-collapse wt-navigation">
											<ul class="navbar-nav">
												<!-- <li style="order: 6;">
													<a href="{{url('articles')}}">
                        								{{{ trans('lang.articles') }}}
                    								</a> -->
                    							</li>
												<li style="order: 2;">
													<a href="{{url('search-results?type=freelancer')}}">
                       									{{{ trans('lang.view_freelancers') }}}
                    								</a>
                    							</li>
												<!--<li style="order: 3;">
													<a href="{{url('search-results?type=employer')}}">
                   										{{{ trans('lang.view_employers') }}}
                									</a>
                								</li> -->
												<li style="order: 4;">
													<a href="{{url('search-results?type=job')}}">
                            							{{{ trans('lang.browse_jobs') }}}
                        							</a>
                        						</li>
												<li style="order: 5;">
													<a href="{{url('search-results?type=service')}}">{{{ trans('lang.browse_services') }}}</a>
												</li>
											</ul>
										</div>
									</nav>
									<div class="wt-loginarea">
										<div class="wt-loginoption wt-loginoptionvtwo"><a href="javascript:void(0);" id="wt-loginbtn" class="wt-btn">Sign In</a>
											<div class="wt-loginformhold">
												<div class="wt-loginheader"><span>Sign In</span> <a href="javascript:;"><i class="fa fa-times"></i></a></div>
												 <form method="POST" action="{{ route('login') }}" class="wt-formtheme wt-loginform do-login-form">
													@csrf
													<fieldset>
														<div class="form-group">
															<input id="email" type="email" name="email" placeholder="Email" required="required" autofocus="autofocus" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
															 @if ($errors->has('email'))
                                                             <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                             </span>
                                                             @endif
														</div>
														<div class="form-group">
															<input id="password" type="password" name="password" placeholder="Password" required="required" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
															 @if ($errors->has('password'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                </span>
                                                                @endif
														</div>
														<div class="wt-logininfo">
															<button href="javascript:;" type="submit" class="wt-btn do-login-button">{{{ trans('lang.login') }}}</button>
															 <span class="wt-checkbox"><input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <label for="remember">{{{ trans('lang.remember') }}}</label></span></div>
													</fieldset>
													<div class="wt-loginfooterinfo">
														@if (Route::has('password.request'))
														<a href="{{ route('password.request') }}" class="wt-forgot-password">{{{ trans('lang.forget_pass') }}}</a>
														@endif 
														<a href="{{{ route('register') }}}">{{{ trans('lang.create_account') }}}</a></div>
												</form>
											</div>
										</div> <a href="{{{ route('register') }}}" class="wt-btn">{{{ trans('lang.join_now') }}}</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="wt-categoriesnav-holder">
					<div class="container-fluid">
						<div class="row">
							<nav class="wt-categories-nav navbar-expand-xl">
								<button type="button" data-toggle="collapse" data-target="#catnavbarNav" aria-controls="catnavbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler catnavbarNav"><i class="lnr lnr-menu"></i></button>
								<div id="catnavbarNav" class="collapse navbar-collapse wt-categories-navbar">
									<ul>
										<?php if(!empty($categories)){?>
										<?php foreach($categories as $key => $value) { ?>
										<li>
											<a href="{{{url('search-results?type=job&&category%5B%5D='.$value['slug'])}}}"><?php echo $value['title']; ?></a>
										</li>
										<?php } ?>
										<?php } ?>
										
									</ul>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</header> 
			<link href="http://amentotech.com/projects/worketic/css/prettyPhoto-min.css" rel="stylesheet">
			<style>
			.wt-header .wt-navigation>ul>.menu-item-has-children:after,
			.wt-header .wt-navigation > ul > li > a {
				color: #ffffff;
			}
			
			.wt-navigation > ul > li.current-menu-item > a,
			.wt-navigation ul li .sub-menu > li:hover > a,
			.wt-navigation > ul > li:hover > a {
				color: #fbde44;
			}
			
			.wt-header .wt-navigationarea .wt-navigation > ul > li > a:after {
				background: #fbde44;
			}
			
			.wt-header .wt-navigationarea .wt-userlogedin .wt-username span,
			.wt-header .wt-navigationarea .wt-userlogedin .wt-username h3 {
				color: #ffffff
			}
			
			;
			</style>
			<main id="wt-main" class="wt-main  wt-haslayout ">
				<div id="wt-demo-sidebar" class="wt-demo-sidebar">
					<!--<div id="wt-btndemotoggle" class="wt-btndemotoggle">
				<span class="menu-icon">
					<i class="lnr lnr-layers"></i>
				</span>
			</div>
			<div id="wt-verticalscrollbar" class="wt-verticalscrollbar mCustomScrollbar _mCS_1"><div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
				
			</div><div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 206px; max-height: 467px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div> -->
					<div class="wt-demo-content">
						<div class="wt-demo-heading">
							<h4>Outstanding Demos</h4>
							<p>With easy<em> ONE CLICK INSTALL</em> and fully customizable options, our demos are the best start you'll ever get!!</p>
							<div class="wt-demo-btns"> <a href="https://codecanyon.net/item/worketic-market-place-for-freelancers/23712284" target="blank" class="wt-demo-btn">Click To LAUNCH</a> </div>
						</div>
					</div>
				</div>
				<div id="pages-list">
					<div>
						<div>
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
						</div>
						<div>
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
						</div>
						<div>
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
						</div>
						<div>
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
						</div>
						<div>
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
						</div>
						<div>
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
							<!---->
						</div>
						<div class="section-main-wrapper10">
							<div>
								<!---->
								<!---->
								<!---->
								<div class="null wt-bannerholdervthree" style="padding: 0px; margin: 0px; background: rgb(255, 255, 255);">
									<div class="wt-bannercontent-wrap">
										<div class="container-fluid">
											<div class="row">
												<div class="col-12">
													<div class="wt-bannerthree-content">
														<div data-v-1fcb3bd6="" class="wt-bannerthree-form">
															<search-theme5-form></search-theme5-form>
															
													
												</div>
												<div class="wt-bannerthree-title"><span style="color: rgb(255, 255, 255);"><h2>Hire professionals</h2></span>
													<h2 style="color: rgb(255, 255, 255);"><em style="color: rgb(255, 255, 255);">for any job, anytime, anywhere </em>
                               
                            </h2>
													<div class="wt-description">
														<p>One place to interview, hire and pay remote freelancers.</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="particles-js" class="wt-particles particles-js">
								<canvas class="particles-js-canvas-el" width="1903" height="914" style="width: 100%; height: 100%;"></canvas>
							</div>
							<div id="wt-home-slider" class="wt-home-slider owl-carousel owl-loaded owl-drag owl-rtl">
								<div class="owl-stage-outer">
									<div class="owl-stage" style="transform: translate3d(5709px, 0px, 0px); transition: all 0s ease 0s; width: 15224px;">
										<div class="owl-item cloned" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246878-img-03.jpg" alt="img description"></figure>
										</div>
										<div class="owl-item cloned" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246878-img-04.jpg" alt="img description"></figure>
										</div>
										<div class="owl-item" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246877-img-01.jpg" alt="img description"></figure>
										</div>
										<div class="owl-item animated owl-animated-in fadeIn active" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246878-img-02.jpg" alt="img description"></figure>
										</div>
										<div class="owl-item" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246878-img-03.jpg" alt="img description"></figure>
										</div>
										<div class="owl-item animated owl-animated-in fadeIn" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246878-img-04.jpg" alt="img description"></figure>
										</div>
										<div class="owl-item cloned" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246877-img-01.jpg" alt="img description"></figure>
										</div>
										<div class="owl-item cloned" style="width: 1903px;">
											<figure class="item"><img src="http://amentotech.com/projects/worketic/uploads/pages/10/1588246878-img-02.jpg" alt="img description"></figure>
										</div>
									</div>
								</div>
								<div class="owl-nav disabled">
									<div class="owl-prev">prev</div>
									<div class="owl-next">next</div>
								</div>
								<div class="owl-dots">
									<div class="owl-dot"><span></span></div>
									<div class="owl-dot active"><span></span></div>
									<div class="owl-dot"><span></span></div>
									<div class="owl-dot"><span></span></div>
								</div>
							</div>
						</div>
					</div>
					<!---->
				</div>
				<div class="section-main-wrapper21">
					<!---->
					<section class="null wt-haslayout  wt-main-section wt-bg-holder wt-categories-wrap" style="padding: 160px 0px; margin: 0px;">
						<div class="wt-overlay-1" style="background-image: url(&quot;http://amentotech.com/projects/worketic/uploads/pages/10/1588246878-img-01.png&quot;);"></div>
						<div class="container">
							<div class="row align-items-center">
								<div class="col-12 col-lg-6">
									<div class="wt-categories-holder">
										<div class="wt-sectionheadvtwo">
											<div class="wt-sectiontitlevtwo"><span style="color: rgb(61, 68, 97);">Explore with our</span>
												<h2 style="color: rgb(61, 68, 97);">Versatile 
                                <em style="color: rgb(144, 19, 254);">Categories </em></h2></div>
											<div class="wt-description">
												<p>eBelong connects professionals directly to individuals and businesses seeking specialized talent services. </p>
											</div>
											<div class="wt-btnarea"><a href="#" class="wt-btntwo">Show All</a></div>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<ul class="wt-categoryvtwo">
										<?php if(!empty($categories)){?>
										<?php foreach($categories as $key => $value) { ?>
										<?php if($key < 4) { ?>
										<li class="active">
											<div class="wt-categorycontentvtwo">
												<figure><img src="{{{ asset(Helper::getCategoryImage($value['image'])) }}}" alt="<?php echo $value['title']; ?>"></figure>
												<div class="wt-cattitlevtwo">
													<h4><a href="{{{url('search-results?type=job&&category%5B%5D='.$value['slug'])}}}"><?php echo $value['title']; ?></a></h4></div>
												<div class="wt-description">
													<p><?php echo $value['abstract']; ?></p>
												</div>
											</div>
										</li>
										<?php } ?>
										<?php } ?>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="section-main-wrapper32">
					<!---->
					<section class="null wt-haslayout wt-main-section wt-section-bg wt-latestjobs-wrap" style="padding: 80px 0px; margin: 108px 0px 0px; background: rgb(245, 247, 250);">
						<div class="wt-border-bg">
							<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 109">
								<defs></defs>
								<title>img-06</title>
								<path d="M0,0c392.2,126.94,699.94,121.9,932.18,75.56,42.25-8.42,62.22-14.27,109.76-24.18,340.48-70.91,642-47.06,878.06,0V109H.17Z" class="cls-3" style="fill: rgb(245, 247, 250); fill-rule: evenodd;"></path>
							</svg>
						</div>
						<div class="wt-overlay-2" style="background-image: url(&quot;http://amentotech.com/projects/worketic/uploads/pages/10/1588246877-img-02.png&quot;);"></div>
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-12 col-lg-8">
									<div class="wt-sectionheadvthree wt-textcenter">
										<div class="wt-sectiontitlevtwo">
											<h2 style="color: rgb(61, 68, 97);">Latest 
                            <em style="color: rgb(144, 19, 243);">Jobs Opening</em></h2></div>
										<div class="wt-description">Join our pool of talented professionals and work from comfort of your home</div>
									</div>
								</div>
								<div class="col-12">
									<div class="wt-latestjobs">
										<ul>
											<?php if(!empty($jobs)) { ?>
											<?php foreach($jobs as $key => $job) { ?>
											<li>
												<div class="wt-latestjob-holder">
													<div class="wt-latestjob-head">
														<figure class="wt-latestjob-logo">
															<img src="http://amentotech.com/projects/worketic/uploads/users/2/a.jpg" alt="img description">
														</figure>
														<div class="wt-latestjob-title">
															<div class="wt-latestjob-tag"><a href="http://amentotech.com/projects/worketic/profile/ava-nguyen"> Ava Nguyen </a></div>
															<h4><a href="{{{url('job/'.$job['slug'])}}}"><?php echo $job['title'];?></a></h4> <span>Australia</span>
														</div>
														<div class="wt-latestjob-right"><span>Remuneration</span>
															<h4><sup>$</sup><?php echo $job['price']; ?></h4> <span><?php echo $job['duration']; ?></span></div>
													</div>
													<div class="wt-latestjob-footer">
														<div class="wt-widgettag">
															<!-- <a href="http://amentotech.com/projects/worketic/search-results?type=job&amp;skills%5B%5D=graphic-design">Graphic Design</a>
															<a href="http://amentotech.com/projects/worketic/search-results?type=job&amp;skills%5B%5D=my-sql">My SQL</a>
															<a href="http://amentotech.com/projects/worketic/search-results?type=job&amp;skills%5B%5D=php">PHP</a> -->
														</div>
														<div class="wt-btnarea">
															<a href="{{{url('job/'.$job['slug'])}}}" class="wt-btntwo">View Job</a>
														</div>
													</div>
												</div>
											</li>
											<?php } ?>
											<?php } ?>
										</ul>
										<div class="wt-btnarea"><a href="javascript:void(0);" class="wt-btntwo">Load More</a>
											<!---->
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>

				<div><section class="wt-haslayout wt-main-section" style="background: rgb(255, 255, 255);"><div class="container"><div class="row"><div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left"><figure class="wt-mobileimg"><img src="https://ebelong.com/uploads/pages/5/1585692219-agency.png" alt="image"></figure></div> <div class="col-12 col-sm-12 col-md-6 col-lg-6 float-left"><div class="wt-experienceholder"><div class="wt-sectionhead"><div class="wt-sectiontitle"><h2>Are you a Business</h2> <span>Looking to hire Work From Home workers</span></div> <div class="wt-description"><p>You can accelerator your business though our platform and innovative tools that helps speed up your day to day business and automate the process of interviewing, hiring and processing payrolls through one single platform.&nbsp;</p>
<p>Our expert Business Support team is one click away to discuss how we can speed up your hiring process. Email us today at <a href="mailto:customer.service@ebelong.com">customer.service@ebelong.com</a>&nbsp;for more details.&nbsp;&nbsp;</p>
<div class="wt-sectiontitle">
<h2>Why EBelong is for Freelancers</h2>
<span>Simple and FREE for Freelancers</span></div>
<div class="wt-description">
	<div>	
	<img src="http://dev.ebelong.com/images/why-ebelong.png" >
	<div class="wt-btnarea" style="margin-top:20px"><a href="http://dev.ebelong.com/register" class="wt-btntwo" style="float:right">Register Now!</a></div>
    </div>
<!-- <table>
<tbody>
<tr>
<td>&nbsp;</td>
<td>Upwork</td>
<td>Freelancer</td>
<td>
<h4><strong>EBelong</strong></h4>
</td>
</tr>
<tr>
<td>
<h5>Price</h5>
</td>
<td>5%-20%</td>
<td>10%-20%</td>
<td>Always FREE</td>
</tr>
<tr>
<td>
<h5>No. Of Bids</h5>
</td>
<td>10/m/$15</td>
<td>15/m/$1</td>
<td>Unlimited</td>
</tr>
<tr>
<td>
<h5>No. Of Skills</h5>
</td>
<td>10</td>
<td>30</td>
<td>Unlimited</td>
</tr>
<tr>
<td>
<h5>Application Denial</h5>
</td>
<td>Highest</td>
<td>HIgh</td>
<td>Lowest</td>
</tr>
<tr>
<td>
<h5>Featured Free</h5>
</td>
<td>No</td>
<td>No</td>
<td>Yes</td>
</tr>
</tbody>
</table> -->
<p>&nbsp;</p>
</div></div></div></div></div></div></div></section> <!----></div>



				
				<div class="section-main-wrapper54">
					<!---->
					<section class="null wt-main-section wt-section-bg wt-freelancers-wrap" style="padding: 80px 0px; margin: 108px 0px 0px; background: rgb(245, 247, 250);">
						<div class="wt-border-bg">
							<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 109">
								<defs></defs>
								<title>img-06</title>
								<path d="M0,0c392.2,126.94,699.94,121.9,932.18,75.56,42.25-8.42,62.22-14.27,109.76-24.18,340.48-70.91,642-47.06,878.06,0V109H.17Z" class="cls-3" style="fill: rgb(245, 247, 250); fill-rule: evenodd;"></path>
							</svg>
						</div>
						<div class="wt-overlay-4" style="background-image: url(&quot;http://amentotech.com/projects/worketic/uploads/pages/10/1588246876-img-03.png&quot;);"></div>
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-12 col-lg-8">
									<div class="wt-sectionheadvthree wt-textcenter">
										<div class="wt-sectiontitlevtwo">
											<h2 style="color: rgb(61, 68, 97);">Top 
                            <em style="color: rgb(144, 19, 254);">Freelancers</em></h2></div>
										<div class="wt-description">
											<p>Complete access to eBelong pool of local talented professionals</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="container-fluid">
							<div class="row">
								<div id="wt-freelancers-silder" class="wt-freelancers-silder"><span id="carousel_prev_s41b8mqah1" style="display: none;"></span>
									<div id="carousel_4iv3b94k0i3" class="owl-carousel owl-theme owl-loaded owl-drag">
										<div class="owl-stage-outer">
											<div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1507px;">
												<?php if(!empty($freelancers)) { ?>
												<?php foreach($freelancers as $key => $freelancer) { ?>
												<?php if($key < 4) { ?>
												<div class="owl-item active" style="width: 346.6px; margin-right: 30px;">
													<div class="wt-freelancer">
														<figure class="wt-freelancer-img"><img src="{{{ asset(Helper::getImageWithSize('uploads/users/'.$freelancer['id'], $freelancer['profile']['avater'], 'listing')) }}}" alt="image"></figure>
														<div class="wt-freelancer-head">
															<div class="wt-freelancer-tag"><a href="{{url('profile/'.$freelancer['slug'])}}"><?php echo $freelancer['first_name']; ?></a></div>
															<div class="wt-title">
																<h3>How Communication Happens</h3></div>
															
															
														</div>
														<ul class="wt-freelancer-footer">
															<li><address><i class="ti-location-pin"></i> United Kingdom</address></li>
															<li><a href="javascript:void(0);" @click.prevent="add_wishlist('freelancer-{{$freelancer['id']}}', {{$freelancer['id']}}, 'saved_freelancer', '{{trans("lang.saved")}}')" id="freelancer-{{$freelancer['id']}}" class="wt-savefreelancer"><i class="ti-heart"></i><span class="save_text">Save </span></a></li>
														</ul>
													</div>
												</div>
												<?php } ?>
												<?php } ?>
												<?php } ?>
											</div>
										</div>
										<div class="owl-nav disabled">
											<div class="owl-prev">next</div>
											<div class="owl-next">prev</div>
										</div>
										<div class="owl-dots disabled"></div>
									</div> <span id="carousel_next_drgaisbyaoh"></span></div>
							</div>
						</div>
					</section>
				</div>
				
		</div>
	</div>
	</main>
	<footer id="wt-footer" class="wt-footertwo wt-haslayout">
		<div class="wt-footer-bg" style="background-image:url()"></div>
		<div class="wt-footerholder wt-haslayout">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-6 col-lg-6">
						<div class="wt-footerlogohold"> <strong class="wt-logo"><a href="{{{ url('/') }}}"><!--<img src="{{{ asset($logo) }}}" alt="company logo here">-->
							<img src="http://dev.ebelong.com/uploads/settings/general/ebelong-logo-footer.png" alt="company logo here" style="width:250px;">
						</a></strong>
							<div class="wt-description">
								<p>Hire professionals for any job, anytime, anywhere</p>
							</div>
							@php Helper::displaySocials(); @endphp

						</div>
					</div>
					@php
        			$footer = \App\SiteManagement::getMetaValue('footer_settings');
        			$search_menu = \App\SiteManagement::getMetaValue('search_menu');
        			$menu_title = DB::table('site_managements')->select('meta_value')->where('meta_key', 'menu_title')->get()->first();
    				@endphp
					<div class="col-12 col-sm-6 col-md-3 col-lg-3">
						<div class="wt-footercol">
							<div class="wt-fwidgettitle">
								<h3>Company</h3> </div>
							@if(!empty($footer['menu_pages_1']))
                                        <ul class="wt-fwidgetcontent">
                                            @foreach($footer['menu_pages_1'] as $menu_1_page)
                                                @php  $page = \App\Page::where('id', $menu_1_page)->first(); @endphp
                                                @if (!empty($page))
                                                    <li><a href="{{{ url('page/'.$page->slug) }}}">{{{ $page->title }}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-3 col-lg-3">
						<div class="wt-footercol wt-widgetexplore">
							<div class="wt-fwidgettitle">
								<h3>Explore More</h3> </div>
							<ul class="wt-fwidgetcontent">
								@foreach($search_menu as $key => $page)
                                    <li><a href="{!! url($page['url']) !!}">{{$page['title']}}</a></li>
                                @endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="wt-haslayout wt-footerbottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<p class="wt-copyrights">Copyright © 2020 Ebelong, All Right Reserved Ebelong</p>
						<nav class="wt-addnav">
							<ul>
								<!--<li><a href="http://amentotech.com/projects/worketic/page/about-us">About Us</a></li>
								<li><a href="http://amentotech.com/projects/worketic/page/privacy-policy">Privacy Policy</a></li> -->
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</footer>
	</div>
	</div>

	<script src="http://amentotech.com/projects/worketic/js/jquery-3.3.1.min.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/tinymce/tinymce.min.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/vendor/jquery-library.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/scrollbar.min.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/particles.min.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/jquery-ui-min.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/prettyPhoto-min.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/owl.carousel.min.js"></script>
	<script src="http://amentotech.com/projects/worketic/js/tilt.jquery.js"></script>
	<script src="{{ asset('js/app.js') }}"></script>

	
	<script>
	footer_element = $('main').hasClass('wt-innerbgcolor');
	if(footer_element) {
		$('.wt-footertwo').addClass('wt-innerbgcolor')
	}
	</script>
	<script src="http://amentotech.com/projects/worketic/js/jquery.dd.min.js"></script>
	
	</script>
	
	<script>
	footer_element = $('main').hasClass('wt-innerbgcolor');
	if(footer_element) {
		$('.wt-footertwo').addClass('wt-innerbgcolor')
	}
	</script>
	<script>
	jQuery(window).load(function() {
		jQuery(".preloader-outer").delay(500).fadeOut();
		jQuery(".pins").delay(500).fadeOut("slow");
	});
	</script>

<script>

$(document).ready(function(){
            $('button.navbar-toggler').click(function() {
                $('#navbarNav').toggle();
                
               });

            $('button.catnavbarNav').click(function() {
                $('#catnavbarNav').toggle();
                $('#navbarNav').css('display','none');
               });
            
            });





</script>


	<script>

particlesJS("particles-js", {
  particles: {
    number: { value: 65, density: { enable: true, value_area: 600 } },
    color: { value: "#ffffff" },
    shape: {
      type: "circle",
      stroke: { width: 0, color: "#000000" },
      polygon: { nb_sides: 5 },
      image: { src: "img/github.svg", width: 100, height: 100 }
    },
    opacity: {
      value: 0.9,
      random: false,
      anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false }
    },
    size: {
      value: 4,
      random: true,
      anim: { enable: false, speed: 40, size_min: 0.1, sync: false }
    },
    line_linked: {
      enable: true,
      distance: 150,
      color: "#ffffff",
      opacity: 0.4,
      width: 1
    },
    move: {
      enable: true,
      speed: 6,
      direction: "none",
      random: false,
      straight: false,
      out_mode: "out",
      bounce: false,
      attract: { enable: false, rotateX: 600, rotateY: 1200 }
    }
  },
  interactivity: {
    detect_on: "canvas",
    events: {
      onhover: { enable: false, mode: "repulse" },
      onclick: { enable: true, mode: "push" },
      resize: true
    },
    modes: {
      grab: { distance: 400, line_linked: { opacity: 1 } },
      bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 },
      repulse: { distance: 200, duration: 0.4 },
      push: { particles_nb: 4 },
      remove: { particles_nb: 2 }
    }
  },
  retina_detect: true
});
var count_particles, stats, update;
stats = new Stats();
stats.setMode(0);
stats.domElement.style.position = "absolute";
stats.domElement.style.left = "0px";
stats.domElement.style.top = "0px";
document.body.appendChild(stats.domElement);
count_particles = document.querySelector(".js-count-particles");
update = function () {
  stats.begin();
  stats.end();
  if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
    count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
  }
  requestAnimationFrame(update);
};
requestAnimationFrame(update);


	</script>

	<script src="https://owlcarousel2.github.io/OwlCarousel2/assets/vendors/jquery.min.js"></script>
    <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>

<script>
            $(document).ready(function() {
              var owl = $('.wt-home-slider');
              owl.owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 6000,
                animateOut: true,
                animateIn: true
              });
              
            })
          </script>

</body>

</html>