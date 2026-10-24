$(document).ready(function () {
  //First Sub Menu Show
  $('#first').click(function () {
    if ($('.menu-first').css('display') == 'none') {
      $('.menu-first').css('display', 'block');
    } else {
      $('.menu-first').css('display', 'none');
    }
  });

  //Second Sub Menu Show
  $('#second').click(function () {
    if ($('.menu-second').css('display') == 'none') {
      $('.menu-second').css('display', 'block');
    } else {
      $('.menu-second').css('display', 'none');
    }
  });

  //Third Sub Menu Show
  $('#third').click(function () {
    if ($('.menu-third').css('display') == 'none') {
      $('.menu-third').css('display', 'block');
    } else {
      $('.menu-third').css('display', 'none');
    }
  });

  //Fourth Sub Menu Show
  $('#fourth').click(function () {
    if ($('.menu-fourth').css('display') == 'none') {
      $('.menu-fourth').css('display', 'block');
    } else {
      $('.menu-fourth').css('display', 'none');
    }
  });

  //Fifth Sub Menu Show
  $('#fifth').click(function () {
    if ($('.menu-fifth').css('display') == 'none') {
      $('.menu-fifth').css('display', 'block');
    } else {
      $('.menu-fifth').css('display', 'none');
    }
  });

  //Sixth Sub Menu Show
  $('#sixth').click(function () {
    if ($('.menu-sixth').css('display') == 'none') {
      $('.menu-sixth').css('display', 'block');
    } else {
      $('.menu-sixth').css('display', 'none');
    }
  });

  //Seventh Sub Menu Show
  $('#seventh').click(function () {
    if ($('.menu-seventh').css('display') == 'none') {
      $('.menu-seventh').css('display', 'block');
    } else {
      $('.menu-seventh').css('display', 'none');
    }
  });

  //Konfirmasi Delete Data Coveralls
  $('#delete-coveralls').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-data-coveralls/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Data Safety Shoes
  $('#delete-safety-shoes').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-data-safety-shoes/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Data Safety Helmet
  $('#delete-safety-helmet').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-data-safety-helmet/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Data Safety Glasses
  $('#delete-safety-glasses').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-data-safety-glasses/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Data Safety Gloves
  $('#delete-safety-gloves').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-data-safety-gloves/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Souvenir
  $('#delete-souvenir').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-data-souvenir/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Other
  $('#delete-other').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-data-other/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Approved Peminjaman
  $('#approved-borrowing').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menyetujui permintaan ini ? ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/approved-status-borrowing-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Approved Permintaan
  $('#approved-request').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menyetujui permintaan ini ? ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/approved-status-request-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Status
  $('#delete-status').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-status-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Rejected Peminjaman
  $('#rejected-borrowing').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Do you want to rejected this request ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Reject',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/rejected-status-borrowing-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Rejected Permintaan
  $('#rejected-request').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Do you want to rejected this request ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Reject',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/rejected-status-request-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Rejected Permintaan
  $('#returned-borrowing').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Do you want to return this borrowing ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Return',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/returned-borrowing-apd-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete User
  $('.delete-user').click(function () {
    const id = $(this).attr('data-id');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-user/' + id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Borrowing
  $('.delete-borrowing').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-borrowing-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });

  //Konfirmasi Delete Request
  $('.delete-request').click(function () {
    const id = $(this).attr('data-id');
    const category = $(this).attr('data-category');
    swal(
      {
        title: 'Konfirmasi',
        text: 'Apakah anda yakin ingin menghapus data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        closeOnConfirm: false,
        closeOnCancel: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          window.location.href =
            'http://localhost/app-apd-hsse/delete-request-' +
            category +
            '/' +
            id;
        } else {
          window.location.href = '';
        }
      },
    );
  });
});
