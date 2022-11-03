
                        <div class="row mb-4 mobile-tab">
                            <div class="col-xm-2" style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('inventory.show', $inventory->id) }}"
                                        class="btn {{  request()->is('inventory/*') ? 'btn-primary' : 'btn-light active p-2' }} mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __("Inventory Data") }} ({{$inventory->immatriculation_number }})
                                    </a>
                                </div>
                            </div>

                            <div class="col-xm-2" style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center"> 
                                    <a href="{{ route('insurance.index', $inventory->id) }}" 
                                        class="btn {{  request()->is('insurance/*') ? 'btn-primary' : 'btn-light active p-2' }}  mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Insurance') }}
                                    </a>
                                </div>
                            </div>

                            <div class="col-xm-2"
                                style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('visit.index', $inventory->id) }}"
                                        class="btn {{  request()->is('visit/*') ? 'btn-primary' : 'btn-light active p-2' }}  mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Technical visit') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-xm-2"
                                style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('insurance.index', $inventory->id) }}"
                                        class="btn {{  request()->is('insurance2/*') ? 'btn-primary' : 'btn-light active p-2' }}  mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Assignment') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-xm-2"
                                style="justify-content: space-between; margin: 0 auto; padding: 8px 0;">
                                <div class="text-center">
                                    <a href="{{ route('insurance.index', $inventory->id) }}"
                                        class="btn {{  request()->is('insurance2/*') ? 'btn-primary' : 'btn-light active p-2' }}  mobile-tab-text"
                                        style="border-radius: 18px 18px 0px 0px;">
                                        {{ __('Maintenance') }}
                                    </a>
                                </div>
                            </div>
                        </div>