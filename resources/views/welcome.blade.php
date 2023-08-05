<head>
    <script src="https://code.jquery.com/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  
  <button class="btn btn-info btn-lg" type="button" data-toggle="modal" data-target="#myModal" tabindex="-1">report</button>
  <div id="myModal" class="modal fade">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
  <h4 class="modal-title">ssss</h4>
  </div>
  <div class="modal-body">
    <div class="popup">
    <form action="#" method="post" enctype="text/plain">
              <input type="text" id="name" name="name" required />
              <label for="name">Ваше имя</label>
              
              <input type="tel" id="tel" name="t" required />
              <label for="tel">Ваш телефон</label>
              
              <input type="e-mail" id="email" name="email" required />
              <label for="email">Ваш Email</label>
              
              <input type="url" id="url" name="url" placeholder="Ваш сайт"/>
              
              
              <select name="service" placeholder="Выбор услуги">
              <option value="1">Выбор услуги</option>
              </select>
              <textarea id="info" placeholder="Дополнительная информация"></textarea>
              
              
              <input type="submit" name="submit" value="Отправить заявку">
          </form>
    </div>
    </div>
  </div>
  </div>
  </div>


  <style>
    * {
  box-sizing: border-box;
}

.popup form {
	width: 100%;
}
input[required] + label, .popup form input, .popup form select, .popup form textarea {
	font-family: "Roboto";
	font-weight: 300;
  color: blue;
  font-size:16px;
}
.popup form input, .popup form select {
	height:38px;
}

.popup form input, .popup form select, .popup form textarea {
	border:1px solid #d0d0d0;
	display: block;
	margin: 0 auto;
	margin-bottom: 20px;
	padding-left: 10px;
	width: 83.55%;
  color: red;
}
input[required] + label {
	position: absolute;
	transform: translateX(60px) translateY(-50px);
}
::-webkit-input-placeholder { 
        color: blue;
        opacity: 1; }
::-moz-placeholder          { color: blue;
        opacity: 1; }
:-moz-placeholder           { color: blue; 
        opacity: 1;}
:-ms-input-placeholder      { color: blue; 
        opacity: 1;}

input[required] + label:after {
    content:'*';
    color: red;
}
input[required]:invalid + label{
    display: inline-block;
}
input[required]:valid + label{
    display: none;
}

.popup form select {
	background-image: url("../image/arr-black.png");
	background-position: right 10px center;
	background-repeat: no-repeat;
     -webkit-appearance: none;
      -moz-appearance: none;
      text-indent: 0.01px; 
      text-overflow: '';
      -ms-appearance: none;
      appearance: none!important;
    color: blue;
}

 .popup form textarea {
	height: 110px;
	padding-top: 10px;
	color: red;
}
.popup form input[type="submit"] {
	background:#dd4949;
	border-radius:3px;
	width:317px;
	height:40px;
	margin-bottom: 0;
	font-weight: 500;
	font-size:1em;
	color:#ffffff;
	line-height:23px;
}
  </style>