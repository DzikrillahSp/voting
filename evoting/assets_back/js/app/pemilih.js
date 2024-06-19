$(document).ready(function () {
  $("#button_insert").click(function () {
    $("#form_insert")[0].reset();
  });

  $(document).on("submit", "#form_insert", function (event) {
    event.preventDefault();
    var nis = $("#nis").val();
    var nama = $("#nama").val();
    var kelas = $("#kelas").val();
    var email = $("#email").val();
    var nowa = $("#nowa").val();
    var file_foto = $(".file_foto").prop("files")[0];

    var formData = new FormData();
    formData.append("nis", nis);
    formData.append("nama", nama);
    formData.append("kelas", kelas);
    formData.append("email", email);
    formData.append("nowa", nowa);
    formData.append("file_foto", file_foto);

    if (nis != "" && nama != "" && kelas != "") {
      $.ajax({
        url: "proses_data/insert_pemilih.php",
        type: "POST",
        dataType: "script",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
          if (response == "success") {
            Swal.fire({
              icon: "success",
              title: "Succed!",
              text: "Successfully added data",
            }).then(function () {
              window.location.reload();
            });
          } else if (response == "size") {
            Swal.fire({
              icon: "warning",
              title: "Sorry!",
              text: "Cover size must be under 2 MB",
            });
          } else if (response == "extentions") {
            Swal.fire({
              icon: "warning",
              title: "Sorry!",
              text: "Extensions must be PNG, JPG and JPEG",
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Sorry!",
              text: "Failed to add data",
            });
          }

          console.log(response);
        },

        error: function (response) {
          Swal.fire({
            icon: "error",
            title: "Oops..!",
            text: "Server error!",
          });

          console.log(response);
        },
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Oops..!",
        text: "All fields must be filled in!",
      });
    }
  });

  $(document).on("click", ".kirim_email", function () {
    var id = $(this).attr("id");
    Swal.fire({
      title: "Wait a moment",
      html: "Is sending...",
      allowOutsideClick: false,
      showConfirmButton: false,
      willOpen: () => {
        Swal.showLoading();
      },
    });
    $.ajax({
      url: "proses_data/kirim_email.php",
      method: "post",
      data: { id: id },
      success: function (response) {
        if (response.trim() == "success") {
          Swal.fire({
            icon: "success",
            title: "Okey!",
            text: "Successfully sent email",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Ops!",
            text: "Failed to send email. Error: " + response,
          });
        }

        console.log(response);
      },

      error: function (xhr, status, error) {
        Swal.fire({
          icon: "error",
          title: "Oops..!",
          text: "Server error! " + xhr.responseText,
        });

        console.log(xhr.responseText);
      },
    });
  });

  $(document).on("click", ".view_data", function () {
    var id = $(this).attr("id");
    // memulai ajax
    $.ajax({
      url: "update/modal_pemilih.php",
      method: "post",
      data: { id: id },
      success: function (data) {
        $("#tampil").html(data);
        $("#modal_update").modal("show");
      },
    });
  });

  $(document).on("submit", "#form_update", function (event) {
    event.preventDefault();
    var id_voter = $("#id_voter").val();
    var nis_update = $("#nis_update").val();
    var nama_update = $("#nama_update").val();
    var kelas_update = $("#kelas_update").val();
    var nowa_update = $("#nowa_update").val();
    var email_update = $("#email_update").val();
    var file_foto_update = $("#file_foto_update").prop("files")[0];

    if (
      id_voter != "" &&
      nis_update != "" &&
      nama_update != "" &&
      kelas_update != ""
    ) {
      var formData = new FormData();
      formData.append("id_voter", id_voter);
      formData.append("nis_update", nis_update);
      formData.append("nama_update", nama_update);
      formData.append("kelas_update", kelas_update);
      formData.append("nowa_update", nowa_update);
      formData.append("email_update", email_update);
      formData.append("file_foto_update", file_foto_update);

      $.ajax({
        url: "proses_data/update_pemilih.php",
        type: "POST",
        dataType: "script",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
          if (response == "success") {
            Swal.fire({
              icon: "success",
              title: "Succed!",
              text: "Successfully changed data",
            }).then(function () {
              window.location.reload();
            });
          } else if (response == "tersedia") {
            Swal.fire({
              icon: "warning",
              title: "Sorry!",
              text: "Matrix is already registered",
            });
          } else if (response == "size") {
            Swal.fire({
              icon: "warning",
              title: "Sorry!",
              text: "Cover size must be under 2 MB",
            });
          } else if (response == "extentions") {
            Swal.fire({
              icon: "warning",
              title: "Sorry!",
              text: "Extensions must be PNG, JPG and JPEG",
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Sorry!",
              text: "Failed to change data",
            });
          }

          console.log(response);
        },

        error: function (response) {
          Swal.fire({
            icon: "error",
            title: "Oops..!",
            text: "Server error!",
          });

          console.log(response);
        },
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Oops..!",
        text: "All fields must be filled in!",
      });
    }
  });

  $(document).on("click", ".hapus", function () {
    Swal.fire({
      title: "Are you sure?",
      text: "Will delete this data!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, sure!",
    }).then((result) => {
      if (result.value) {
        var id = $(this).attr("data-id");
        $.ajax({
          method: "POST",
          url: "proses_data/delete_pemilih.php",
          data: {
            id: id,
          },
          success: function (response) {
            if (response == "success") {
              Swal.fire({
                icon: "success",
                title: "Succed!",
                text: "Successfully deleted data",
              }).then(function () {
                window.location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Sorry!",
                text: "Failed to delete data",
              });
            }
            console.log(response);
          },
        });
      }
    });
  });

  $(document).on("click", ".generate", function (event) {
    event.preventDefault();

    var id = $(this).attr("data-id");
    var generate = "generate";

    if (id == "") {
      Swal.fire({
        icon: "error",
        title: "Oops..!",
        text: "No data selected",
      });
    } else {
      $.ajax({
        url: "proses_data/generate_pemilih.php",
        method: "POST",
        data: {
          id: id,
          generate: generate,
        },
        beforeSend: function () {
          Swal.fire({
            title: "",
            html: "Wait a moment...",
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
              Swal.showLoading();
            },
          });
        },
        success: function (response) {
          if (response == "success") {
            Swal.fire({
              icon: "success",
              title: "Okey!",
              text: "Successfully regenerated the access code",
            }).then(function () {
              window.location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Sorry!",
              text: "There is a problem going on",
            });
          }

          console.log(response);
        },

        error: function (response) {
          Swal.fire({
            icon: "error",
            title: "Oops..!",
            text: "Server error!",
          });

          console.log(response);
        },
      });
    }
  });

  $(document).on("click", ".update-all", function (event) {
    event.preventDefault();
    var status = "status";
    Swal.fire({
      title: "Are you sure?",
      html: "If you update your voter status, all data in the ballot box will be deleted! <br> <b>Be careful when using this feature!</b>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, sure!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "proses_data/generate_pemilih.php",
          method: "POST",
          data: {
            status: status,
          },
          beforeSend: function () {
            Swal.fire({
              title: "",
              html: "Wait a moment...",
              allowOutsideClick: false,
              showConfirmButton: false,
              willOpen: () => {
                Swal.showLoading();
              },
            });
          },
          success: function (response) {
            if (response == "success") {
              Swal.fire({
                icon: "success",
                title: "Succed!",
                text: "Successfully changed all voter status",
              }).then(function () {
                window.location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Sorry!",
                text: "Failed to change all voter status",
              });
            }

            console.log(response);
          },

          error: function (response) {
            Swal.fire({
              icon: "error",
              title: "Oops..!",
              text: "Server error!",
            });

            console.log(response);
          },
        });
      }
    });
  });

  $(document).on("click", ".generate-all", function (event) {
    event.preventDefault();
    var generate_all = "generate";

    Swal.fire({
      title: "Are you sure?",
      text: "To generate all voter access codes",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, sure!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "proses_data/generate_pemilih.php",
          method: "POST",
          data: {
            generate_all: generate_all,
          },
          beforeSend: function () {
            Swal.fire({
              title: "",
              html: "Wait a moment...",
              allowOutsideClick: false,
              showConfirmButton: false,
              willOpen: () => {
                Swal.showLoading();
              },
            });
          },
          success: function (response) {
            if (response == "success") {
              Swal.fire({
                icon: "success",
                title: "Okey!",
                text: "Successfully regenerated all access codes",
              }).then(function () {
                window.location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Sorry!",
                text: "There is a problem going on",
              });
            }

            console.log(response);
          },

          error: function (response) {
            Swal.fire({
              icon: "error",
              title: "Oops..!",
              text: "Server error!",
            });

            console.log(response);
          },
        });
      }
    });
  });

  $(document).on("click", ".send-email-all", function (event) {
    event.preventDefault();
    var send_email = "send_email";

    Swal.fire({
      title: "Announcement",
      text: "To send an email at the same time you need a smooth network, of course it will take some time to send and make sure you don't reload this page!",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, send!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "proses_data/generate_pemilih.php",
          method: "POST",
          data: {
            send_email: send_email,
          },
          beforeSend: function () {
            Swal.fire({
              title: "Wait a moment",
              html: "Do not refresh the page...",
              allowOutsideClick: false,
              showConfirmButton: false,
              willOpen: () => {
                Swal.showLoading();
              },
            });

            $("#send-email-all").html("Is sending...");

            $(".button_insert").prop("disabled", true);
            $(".import_data_btn").hide();
            $(".generate-all").prop("disabled", true);
            $(".send-email-all").prop("disabled", true);
            $(".update-all").prop("disabled", true);
          },
          success: function (response) {
            if (response == "success") {
              $("#send-email-all").html(
                '<i class="fa fa-envelope"></i> Send Access Code'
              );

              $(".button_insert").prop("disabled", "");
              $(".import_data_btn").show();
              $(".generate-all").prop("disabled", "");
              $(".send-email-all").prop("disabled", "");
              $(".update-all").prop("disabled", "");

              Swal.fire({
                icon: "success",
                title: "Okey!",
                text: "Successfully sent access code",
              });
            } else {
              $("#send-email-all").html(
                '<i class="fa fa-envelope"></i> Send Access Code'
              );

              $(".button_insert").prop("disabled", "");
              $(".import_data_btn").show();
              $(".generate-all").prop("disabled", "");
              $(".send-email-all").prop("disabled", "");
              $(".update-all").prop("disabled", "");

              Swal.fire({
                icon: "error",
                title: "Sorry!",
                text: "There is a problem going on",
              });
            }

            console.log(response);
          },

          error: function (response) {
            $("#send-email-all").html(
              '<i class="fa fa-envelope"></i> Send Access Code'
            );

            $(".button_insert").prop("disabled", "");
            $(".import_data_btn").show();
            $(".generate-all").prop("disabled", "");
            $(".send-email-all").prop("disabled", "");
            $(".update-all").prop("disabled", "");

            Swal.fire({
              icon: "error",
              title: "Oops..!",
              text: "Server error!",
            });

            console.log(response);
          },
        });
      }
    });
  });
});
