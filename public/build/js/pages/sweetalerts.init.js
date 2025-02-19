function confirmDelete(id_wahana) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus saja!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id_wahana}`).submit();
        }
    });
}


function confirmDelete(id_question) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Anda tidak akan bisa mengembalikannya lagi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus saja!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id_question}`).submit();
        }
    });
}


