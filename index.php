<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
	<title>Unblock panel</title>

  <link rel="stylesheet" href="./css/bootstrap.css">
	<link rel="stylesheet" href="./css/bootstrap-theme.css">
  </head>
  <body>
<header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white">
    <a class="navbar-brand" href="#">Unblock</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <div class="form-inline">
            <input class="form-control" type="text" placeholder="telegram.org" id="input_search">
            <button class="btn btn-outline-warning" id="btn_search">Найти</button>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#rawModal" id="link_show_raw_modal">Весь список</a>
        </li>
      </ul>
      <button id="btn_save" class="btn btn-outline-primary">Сохранить</button>
    </div>
  </nav>
</header>

<main role="main" class="container">
  <form action="./src/handler.php?action=parse" id="form_main" method="POST"></form>
</main><!-- /.container -->

<div class="modal fade" id="rawModal" tabindex="-1" role="dialog" aria-labelledby="rawModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rawModalLabel">Весь список</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea name="text" id="textarea_raw" class="form-control" rows="20">
        </textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary" id="btn_raw_save">Сохранить</button>
      </div>
    </div>
  </div>
</div>

<script src="./js/jquery-3.4.1.js"></script>
<script src="./js/bootstrap.bundle.js"></script>
<script src="./js/jquery.repeater.js"></script>
<script src="./js/sweetalert.min.js"></script>
<script src="./js/jquery.blockUI.js"></script>
<script src="./js/main.js"></script>
</body>
</html>
