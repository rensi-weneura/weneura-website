<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <?php if (!empty($success)): ?>
      <div class="alert alert-success"><?= e($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header d-flex flex-column flex-md-row justify-content-between">
        <h5 class="card-title mb-0">Service Category List</h5>
        <a href="/admin/service-category/add" class="btn btn-primary waves-effect waves-light">
          <i class="ti ti-plus me-sm-1"></i> Add Category
        </a>
      </div>
      <hr class="my-0">
      <div class="card-datatable text-nowrap">
        <table class="table ajax_datatable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Slug</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<?php ob_start(); ?>
<script src="<?= asset('vendor/libs/datatables-bs5/datatables-bootstrap5.js') ?>"></script>
<script src="<?= asset('vendor/libs/sweetalert2/sweetalert2.js') ?>"></script>
<script>
  const csrf = $('meta[name="csrf-token"]').attr('content');

  const table = $('.ajax_datatable').DataTable({
    ajax: { url: '/admin/service-category/data', type: 'GET', dataSrc: 'data' },
    pageLength: 10,
    columns: [
      {
        data: null,
        render: (d, t, r, meta) => meta.row + meta.settings._iDisplayStart + 1
      },
      { data: 'name', render: $.fn.dataTable.render.text() },
      { data: 'slug', render: $.fn.dataTable.render.text() },
      {
        data: 'status',
        orderable: false,
        render: (data, type, row) => `
          <select data-id="${row.id}" class="form-select change-status" style="min-width:120px">
            <option value="1" ${data == 1 ? 'selected' : ''}>Active</option>
            <option value="0" ${data == 0 ? 'selected' : ''}>Inactive</option>
          </select>`
      },
      { data: 'created_at' },
      {
        data: 'id',
        orderable: false,
        searchable: false,
        render: (id) => `
          <div class="d-flex align-items-center">
            <a href="/admin/service-category/edit/${id}" class="btn btn-icon btn-text-secondary rounded-pill">
              <i class="ti ti-edit"></i>
            </a>
            <a href="#" class="btn btn-icon btn-text-danger rounded-pill delete-record" data-id="${id}">
              <i class="ti ti-trash ti-md"></i>
            </a>
          </div>`
      }
    ]
  });

  $('.ajax_datatable').on('change', '.change-status', function () {
    $.post('/admin/service-category/status', {
      _token: csrf,
      id: $(this).data('id'),
      status: $(this).val()
    }).fail(() => Swal.fire({ icon: 'error', title: 'Error!', text: 'Status update failed' }));
  });

  $('.ajax_datatable').on('click', '.delete-record', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    const row = table.row($(this).closest('tr'));

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-2',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then((result) => {
      if (!result.isConfirmed) return;

      $.post(`/admin/service-category/delete/${id}`, { _token: csrf })
        .done(() => {
          Swal.fire({ icon: 'success', title: 'Deleted!', text: 'Service category has been removed.' })
            .then(() => row.remove().draw());
        })
        .fail((xhr) => {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: (xhr.responseJSON && xhr.responseJSON.message) || 'Something went wrong!'
          });
        });
    });
  });
</script>
<?php $pageScripts = ob_get_clean(); ?>