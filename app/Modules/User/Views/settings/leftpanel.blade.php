@section('left-panel')
<div class="account-nav-col">
     
                     <ul>

                        <li>
                            <a href="{{route('user.show.setting.page')}}" class="@if(in_array(Request::route()->getName(),['user.show.setting.page','user.edit.account.information'])) active @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-left"><path fill="none" d="M0 0h24v24H0z" /><path d="M2 3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H2.992A.993.993 0 0 1 2 20.007V3.993zM4 5v14h16V5H4zm2 2h6v6H6V7zm2 2v2h2V9H8zm-2 6h12v2H6v-2zm8-8h4v2h-4V7zm0 4h4v2h-4v-2z"/></svg>
                              Profile Overview
                           </a>
                        </li>
                        <li >
                              <a href="{{route('user.change.password')}}" class="@if(in_array(Request::route()->getName(),['user.change.password'])) active @endif">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="15" height="17.593" viewBox="0 0 15 17.593" class="icon-left">
                                    <path id="icon" class="cls-1" d="M108.5,351.052h1.666a0.835,0.835,0,0,1,.833.838v10.056a0.836,0.836,0,0,1-.833.838H96.831A0.836,0.836,0,0,1,96,361.946V351.89a0.836,0.836,0,0,1,.833-0.838H98.5v-0.838a5,5,0,1,1,10,0v0.838Zm-10.834,1.676v8.379h11.667v-8.379H97.665Zm5,3.352h1.667v1.676h-1.667V356.08Zm-3.334,0H101v1.676H99.331V356.08Zm6.667,0h1.667v1.676H106V356.08Zm0.834-5.028v-0.838a3.334,3.334,0,1,0-6.667,0v0.838h6.667Z" transform="translate(-96 -345.188)"/>
                                 </svg>
                                 Change Password
                              </a>
                        </li>
                        <li>
                           <a href="{{route('user.change.mobile')}}" class="@if(in_array(Request::route()->getName(),['user.change.mobile'])) active @endif">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16.5" height="16.5" viewBox="0 0 16.5 16.5"  class="icon-left">
                                 <path id="icon" class="cls-1" d="M101.085,426.292a9.672,9.672,0,0,0,3.622,3.622l0.81-1.135a0.918,0.918,0,0,1,1.187-.271,10.464,10.464,0,0,0,4.2,1.25,0.918,0.918,0,0,1,.845.915v4.089a0.917,0.917,0,0,1-.823.913,14.217,14.217,0,0,1-15.6-15.6,0.917,0.917,0,0,1,.912-0.823h4.09a0.915,0.915,0,0,1,.914.844,10.465,10.465,0,0,0,1.251,4.2,0.916,0.916,0,0,1-.272,1.186Zm-2.312-.6,1.742-1.244a12.252,12.252,0,0,1-1.006-3.362H97.092c-0.006.152-.008,0.3-0.008,0.458a12.373,12.373,0,0,0,12.374,12.375c0.154,0,.306,0,0.458-0.009V431.49a12.323,12.323,0,0,1-3.362-1l-1.244,1.741a11.432,11.432,0,0,1-1.455-.687l-0.054-.031a11.51,11.51,0,0,1-4.31-4.31l-0.03-.053A11.316,11.316,0,0,1,98.773,425.689Z" transform="translate(-95.25 -419.25)"/>
                              </svg>
                              Change Contact Info
                           </a>
                        </li>
                        <li>
                           <a href="{{route('user.show.change.address')}}" class="@if(in_array(Request::route()->getName(),['user.show.change.address'])) active @endif">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" class="icon-left"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 18.485l4.243-4.242a6 6 0 1 0-8.486 0L12 18.485zm5.657-2.828L12 21.314l-5.657-5.657a8 8 0 1 1 11.314 0zM5 22h14v2H5v-2z"/></svg>
                                 Manage Addresses
                           </a>
                        </li>
                        <li>
                            <a href="{{route('user.show.terms-condition.page')}}" class="@if(in_array(Request::route()->getName(),['user.show.terms-condition.page'])) active @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14.969" height="16.625" viewBox="0 0 14.969 16.625" class="icon-left">
                                 <path id="icon" class="cls-1" d="M109.983,568.177v10.786a0.831,0.831,0,0,1-.827.835H95.813a0.825,0.825,0,0,1-.827-0.823V564.02a0.836,0.836,0,0,1,.835-0.823h9.16Zm-1.667.83h-4.165v-4.15h-7.5v13.281h11.664v-9.131Zm-9.164-1.66h2.5v1.66h-2.5v-1.66Zm0,3.321h6.665v1.66H99.152v-1.66Zm0,3.32h6.665v1.66H99.152v-1.66Z" transform="translate(-95 -563.188)"/>
                           </svg>

                                Terms and Conditions
                           </a>
                        </li>
                        <li>
                            <a href="{{route('user.show.privacy-policy.page')}}" class="@if(in_array(Request::route()->getName(),['user.show.privacy-policy.page'])) active @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16.625" viewBox="0 0 15 16.625" class="icon-left">
                              <path class="cls-1" d="M110.165,653.8H96.831A0.831,0.831,0,0,1,96,652.969V638.027a0.831,0.831,0,0,1,.833-0.83h13.334a0.831,0.831,0,0,1,.833.83v14.942A0.831,0.831,0,0,1,110.165,653.8Zm-0.833-1.66V638.857H97.665v13.281h11.667Zm-9.167-10.791h6.667v1.66h-6.667v-1.66Zm0,3.32h6.667v1.661h-6.667v-1.661Zm0,3.321h6.667v1.66h-6.667v-1.66Z" transform="translate(-96 -637.188)"/>
                              </svg>
                              Privacy Policy
                           </a>
                        </li>
                        <li >
                            <a href="{{route('user.show.help.page')}}" class="@if(in_array(Request::route()->getName(),['user.show.help.page'])) active @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.626" height="16.625" viewBox="0 0 16.626 16.625" class="icon-left">
                              <path id="icon" class="cls-1" d="M104.5,726.8a8.3,8.3,0,1,1,8.3-8.3A8.3,8.3,0,0,1,104.5,726.8Zm0-1.661a6.641,6.641,0,1,0-6.641-6.641A6.64,6.64,0,0,0,104.5,725.138Zm-0.83-4.15h1.66v1.66h-1.66v-1.66Zm1.66-1.366v0.535h-1.66v-1.245a0.83,0.83,0,0,1,.83-0.83,1.245,1.245,0,1,0-1.222-1.489l-1.628-.326A2.906,2.906,0,1,1,105.327,719.622Z" transform="translate(-96.188 -710.188)"/>
                              </svg>
                              Help
                           </a>
                        </li>
                        <li >
                            <a href="{{route('user.show.contact-us.page')}}" class="@if(in_array(Request::route()->getName(),['user.show.contact-us.page'])) active @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" class="icon-left"><path fill="none" d="M0 0h24v24H0z"/><path d="M20 22H6a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zm-1-2v-2H6a1 1 0 0 0 0 2h13zM5 16.17c.313-.11.65-.17 1-.17h13V4H6a1 1 0 0 0-1 1v11.17zM12 10a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm-3 4a3 3 0 0 1 6 0H9z" /></svg>
                              Contact Us         
                           </a>
                        </li>
                        <li>
                            <a href="{{route('user.show.faq.page')}}" class="@if(in_array(Request::route()->getName(),['user.show.faq.page'])) active @endif">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16.626" height="16.188" viewBox="0 0 16.626 16.188"  class="icon-left">
                                 <path id="icon" class="cls-1" d="M98.321,795.029h11.818V785.06H96.857v11.12Zm0.574,1.662L95.2,799.6v-15.37a0.83,0.83,0,0,1,.83-0.831h14.942a0.831,0.831,0,0,1,.83.831V795.86a0.831,0.831,0,0,1-.83.831H98.9Zm3.772-4.154h1.661V794.2h-1.661v-1.661Zm-2.019-4.31a2.906,2.906,0,1,1,2.849,3.479h-0.83v-1.661h0.83a1.247,1.247,0,1,0-1.22-1.491Z" transform="translate(-95.188 -783.406)"/>
                              </svg>
                              FAQs
                           </a>
                        </li>

                        <li>
                           <a href="{{route('user.show.about-us.page')}}" class="@if(in_array(Request::route()->getName(),['user.show.about-us.page'])) active @endif">

                           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                              viewBox="0 0 502.643 502.643" style="enable-background:new 0 0 502.643 502.643;" xml:space="preserve" class="icon-left">
                                 <g>
                                    <g>
                                       <path d="M251.256,237.591c37.166,0,67.042-30.048,67.042-66.977c0.043-37.037-29.876-66.999-67.042-66.999
                                          c-36.908,0-66.869,29.962-66.869,66.999C184.387,207.587,214.349,237.591,251.256,237.591z"/>
                                       <path d="M305.032,248.506H197.653c-19.198,0-34.923,17.602-34.923,39.194v107.854c0,1.186,0.604,2.243,0.669,3.473h175.823
                                          c0.129-1.229,0.626-2.286,0.626-3.473V287.7C339.912,266.108,324.187,248.506,305.032,248.506z"/>
                                       <path d="M431.588,269.559c29.832,0,53.754-24.008,53.754-53.668s-23.922-53.711-53.754-53.711
                                          c-29.617,0-53.582,24.051-53.582,53.711C377.942,245.53,401.972,269.559,431.588,269.559z"/>
                                       <path d="M474.708,278.317h-86.046c-15.445,0-28.064,14.107-28.064,31.472v86.413c0,0.928,0.453,1.812,0.518,2.826h141.03
                                          c0.065-1.014,0.496-1.898,0.496-2.826v-86.413C502.707,292.424,490.11,278.317,474.708,278.317z"/>
                                       <path d="M71.011,269.559c29.789,0,53.733-24.008,53.733-53.668S100.8,162.18,71.011,162.18c-29.638,0-53.603,24.051-53.603,53.711
                                          S41.373,269.559,71.011,269.559L71.011,269.559z"/>
                                       <path d="M114.109,278.317H27.977C12.576,278.317,0,292.424,0,309.789v86.413c0,0.928,0.453,1.812,0.539,2.826h141.03
                                          c0.065-1.014,0.475-1.898,0.475-2.826v-86.413C142.087,292.424,129.489,278.317,114.109,278.317z"/>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                    <g>
                                    </g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                                 <g>
                                 </g>
                           </svg>
                           About Us
                          </a>
                       </li>

                     </ul>
                  </div>
                  @endsection