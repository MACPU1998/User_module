@extends('layouts.project-master')

@section('title', 'RAYKAIO')

@section('content')
<div class="body-wrapper">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body pb-0" data-simplebar="">
              <div class="row flex-nowrap">
                <div class="col">
                  <div class="card primary-gradient">
                    <div class="card-body text-center px-9 pb-4">
                      <div
                        class="d-flex align-items-center justify-content-center round-48 rounded text-bg-primary flex-shrink-0 mb-3 mx-auto">
                        <iconify-icon icon="solar:dollar-minimalistic-linear"
                          class="fs-7 text-white"></iconify-icon>
                      </div>
                      <h6 class="fw-normal fs-3 mb-1">Total Orders</h6>
                      <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                        16,689</h4>
                      <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                        Details</a>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card warning-gradient">
                    <div class="card-body text-center px-9 pb-4">
                      <div
                        class="d-flex align-items-center justify-content-center round-48 rounded text-bg-warning flex-shrink-0 mb-3 mx-auto">
                        <iconify-icon icon="solar:recive-twice-square-linear"
                          class="fs-7 text-white"></iconify-icon>
                      </div>
                      <h6 class="fw-normal fs-3 mb-1">Return Item</h6>
                      <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                        148</h4>
                      <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                        Details</a>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card secondary-gradient">
                    <div class="card-body text-center px-9 pb-4">
                      <div
                        class="d-flex align-items-center justify-content-center round-48 rounded text-bg-secondary flex-shrink-0 mb-3 mx-auto">
                        <iconify-icon icon="ic:outline-backpack" class="fs-7 text-white"></iconify-icon>
                      </div>
                      <h6 class="fw-normal fs-3 mb-1">Annual Budget</h6>
                      <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                        $156K</h4>
                      <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                        Details</a>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card danger-gradient">
                    <div class="card-body text-center px-9 pb-4">
                      <div
                        class="d-flex align-items-center justify-content-center round-48 rounded text-bg-danger flex-shrink-0 mb-3 mx-auto">
                        <iconify-icon icon="ic:baseline-sync-problem" class="fs-7 text-white"></iconify-icon>
                      </div>
                      <h6 class="fw-normal fs-3 mb-1">Cancel Orders</h6>
                      <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                        64</h4>
                      <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                        Details</a>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="card success-gradient">
                    <div class="card-body text-center px-9 pb-4">
                      <div
                        class="d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mb-3 mx-auto">
                        <iconify-icon icon="ic:outline-forest" class="fs-7 text-white"></iconify-icon>
                      </div>
                      <h6 class="fw-normal fs-3 mb-1">Total Income</h6>
                      <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">
                        $36,715</h4>
                      <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                        Details</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <!-- -------------------------------------------- -->
          <!-- Revenue by Product -->
          <!-- -------------------------------------------- -->
          <div class="card">
            <div class="card-body">
              <div class="d-flex flex-wrap gap-3 mb-2 justify-content-between align-items-center">
                <h5 class="card-title fw-semibold mb-0">دستگاه های من</h5>
              </div>
              <div class="tab-content mb-n3">
                <div class="tab-pane active" id="app" role="tabpanel">
                  <div class="table-responsive" data-simplebar>
                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                      <thead>
                        <tr>
                          <th scope="col" class="text-dark fw-normal ps-0">عنوان
                          </th>
                          <th scope="col" class="text-dark fw-normal">وضعیت</th>
                          <th scope="col" class="text-dark fw-normal">اخرین داده</th>
                          <th scope="col" class="text-dark fw-normal">عملیات</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Minecraf App</h6>
                                <span>Jason Roy</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-success-subtle text-success">Low</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Web App Project</h6>
                                <span>Mathew Flintoff</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Modernize Dashboard</h6>
                                <span>Anil Kumar</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-secondary-subtle text-secondary">Very
                              High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Dashboard Co</h6>
                                <span>George Cruize</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-danger-subtle text-danger">High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="mobile" role="tabpanel">
                  <div class="table-responsive" data-simplebar>
                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                      <thead>
                        <tr>
                          <th scope="col" class="text-dark fw-normal ps-0">Assigned
                          </th>
                          <th scope="col" class="text-dark fw-normal">Progress</th>
                          <th scope="col" class="text-dark fw-normal">Priority</th>
                          <th scope="col" class="text-dark fw-normal">Budget</th>
                        </tr>
                      </thead>
                      <tbody>

                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Web App Project</h6>
                                <span>Mathew Flintoff</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Modernize Dashboard</h6>
                                <span>Anil Kumar</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-secondary-subtle text-secondary">Very
                              High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Minecraf App</h6>
                                <span>Jason Roy</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-success-subtle text-success">Low</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Dashboard Co</h6>
                                <span>George Cruize</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-danger-subtle text-danger">High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="saas" role="tabpanel">
                  <div class="table-responsive" data-simplebar>
                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                      <thead>
                        <tr>
                          <th scope="col" class="text-dark fw-normal ps-0">Assigned
                          </th>
                          <th scope="col" class="text-dark fw-normal">Progress</th>
                          <th scope="col" class="text-dark fw-normal">Priority</th>
                          <th scope="col" class="text-dark fw-normal">Budget</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Web App Project</h6>
                                <span>Mathew Flintoff</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Minecraf App</h6>
                                <span>Jason Roy</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-success-subtle text-success">Low</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>

                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Modernize Dashboard</h6>
                                <span>Anil Kumar</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-secondary-subtle text-secondary">Very
                              High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Dashboard Co</h6>
                                <span>George Cruize</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-danger-subtle text-danger">High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane" id="other" role="tabpanel">
                  <div class="table-responsive" data-simplebar>
                    <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                      <thead>
                        <tr>
                          <th scope="col" class="text-dark fw-normal ps-0">Assigned
                          </th>
                          <th scope="col" class="text-dark fw-normal">Progress</th>
                          <th scope="col" class="text-dark fw-normal">Priority</th>
                          <th scope="col" class="text-dark fw-normal">Budget</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-1.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Minecraf App</h6>
                                <span>Jason Roy</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-success-subtle text-success">Low</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-3.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Modernize Dashboard</h6>
                                <span>Anil Kumar</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-secondary-subtle text-secondary">Very
                              High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-2.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Web App Project</h6>
                                <span>Mathew Flintoff</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-warning-subtle text-warning">Medium</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>

                        <tr>
                          <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                              <img src="../assets/images/products/dash-prd-4.jpg" alt="prd1" width="48"
                                class="rounded" />
                              <div>
                                <h6 class="mb-0">Dashboard Co</h6>
                                <span>George Cruize</span>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span>73.2%</span>
                          </td>
                          <td>
                            <span class="badge bg-danger-subtle text-danger">High</span>
                          </td>
                          <td>
                            <span class="text-dark">$3.5k</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
