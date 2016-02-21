<style scoped>
#idiv
{
	background-image:url('./background.png');
	background-size:100% 100%;
	position:fixed;
	top:0;
	left:0;
	width:100%;
	height:100%;
	background-color:white;
}
.btn
{
	position:relative;
	top:50%;
	left:25%;
	width:50%;
	text-align:center;
	display:inline-block;
	margin-right:100px;
	padding:30px;
	color:black;
	font-weight:bold;
	font-size:2em;
	cursor:pointer;
}
.btn:hover
{
	box-shadow:0 0 10px #f00;
	text-decoration:underline;
}
</style>
<div id="idiv">
	<div onclick="location.href='post.php'" class="btn">Discovery what's happening near you</div>
</div>
