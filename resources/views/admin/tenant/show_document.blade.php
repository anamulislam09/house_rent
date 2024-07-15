@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS for styling -->
    <style>
        .document-img {
            width: 30%;
            height: 30%;
            object-fit: cover;
            cursor: pointer;
            transition: .3s;
        }

        .document-img:hover {
            transform: scale(1.1);
        }

        .modal-body {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        h5.card-title {
            margin-right: 10%;
        }

        .modal-body img {
            max-width: 100%;
            max-height: 100%;
            margin: auto;
        }
    </style>

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header bg-primary text">
                        <h3 class="card-title">Tenant Document Details</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Tenant Information</h3>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Name:</strong> {{ $tenant->name }}</li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $tenant->phone }}</li>
                            <li class="list-group-item"><strong>NID No:</strong> {{ $tenant->nid_no }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $tenant->email }}</li>
                            <li class="list-group-item"><strong>Address:</strong> {{ $tenant->address }}</li>
                        </ul>
                    </div>
                </div>
                <h3 class="mt-2">All Documents</h3>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">National ID (NID)</h5>
                                <img src="{{ asset($tenant_document->nid) }}" class="document-img" alt="NID Document" data-toggle="modal" data-target="#imageModal" data-image="{{ asset($tenant_document->nid) }}" data-name="National ID (NID)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">TIN Number</h5>
                                <img src="{{ asset($tenant_document->tin) }}" class="document-img" alt="TIN Document" data-toggle="modal" data-target="#imageModal" data-image="{{ asset($tenant_document->tin) }}" data-name="TIN Number">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Tenant Photo</h5>
                                <img src="{{ asset($tenant_document->photo) }}" class="document-img" alt="Tenant Photo" data-toggle="modal" data-target="#imageModal" data-image="{{ asset($tenant_document->photo) }}" data-name="Tenant Photo">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Deed</h5>
                                <img src="{{ asset($tenant_document->deed) }}" class="document-img" alt="Deed Document" data-toggle="modal" data-target="#imageModal" data-image="{{ asset($tenant_document->deed) }}" data-name="Deed">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Police Form</h5>
                                <img src="{{ asset($tenant_document->police_form) }}" class="document-img" alt="Police Form" data-toggle="modal" data-target="#imageModal" data-image="{{ asset($tenant_document->police_form) }}" data-name="Police Form">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for displaying full image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Document Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" id="fullImage" class="img-fluid" alt="Document Image">
                </div>
                <div class="modal-footer">
                    <h5 id="imageName"></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var imageUrl = button.data('image');
            var imageName = button.data('name');
            var modal = $(this);
            modal.find('.modal-body img').attr('src', imageUrl);
            modal.find('.modal-footer #imageName').text(imageName);
        });
    </script>
@endsection
