<!--begin::Widget 29-->
                                        <div class="m-widget29">
                                            <div class="m-widget_content">
                                                <h3 class="m-widget_content-title">Files</h3>
                                                <div class="m-widget_content-items">
                                                    <div class="m-widget_content-item">
                                                        <span>Total</span>
                                                        <span class="m--font-accent">{{ number_format($count['fileCount']) }}</span>
                                                    </div>
                                                    <div class="m-widget_content-item">
                                                        <span>New</span>
                                                        <span>{{ number_format($count['fileCountP']) }}</span>
                                                    </div>
                                                    <div class="m-widget_content-item">
                                                        <span>Change</span>
                                                        <span class="m--font-brand">{{ number_format($count['fileCountP'] * 100 / $count['fileCount']) }}%</span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="m-widget_content">
                                                <h3 class="m-widget_content-title">File Categories</h3>
                                                <div class="m-widget_content-items">
                                                    <div class="m-widget_content-item">
                                                        <span>Total</span>
                                                        <span class="m--font-accent">{{ number_format($count['folderCount']) }}</span>
                                                    </div>
                                                    <div class="m-widget_content-item">
                                                        <span>New</span>
                                                        <span>{{ number_format($count['folderCountP']) }}</span>
                                                    </div>
                                                    <div class="m-widget_content-item">
                                                        <span>Change</span>
                                                        <span class="m--font-brand">{{ number_format($count['folderCountP'] * 100 / $count['folderCount']) }}%</span>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            @if((Auth::user()->access_type != 'General staff' || Auth::user()->access_type !=  "Limited Staff"))
                                            <div class="m-widget_content">
                                                <h3 class="m-widget_content-title">User</h3>
                                                <div class="m-widget_content-items">
                                                    <div class="m-widget_content-item">
                                                        <span>Total</span>
                                                        <span class="m--font-accent">{{ number_format($count['userCount']) }}</span>
                                                    </div>
                                                    <div class="m-widget_content-item">
                                                        <span>New</span>
                                                        <span>{{ number_format($count['userCountP']) }}</span>
                                                    </div>
                                                    <div class="m-widget_content-item">
                                                        <span>Change</span>
                                                        <span class="m--font-brand">{{ number_format($count['userCountP'] * 100 / $count['userCount']) }}%</span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            @endif
                                        </div>