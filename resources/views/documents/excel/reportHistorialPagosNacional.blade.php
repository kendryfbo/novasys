
	<!-- box -->
		<!-- box-header -->
		<div class="box-header text-center">
			<!-- box-body -->
		<div class="box-body">
			<!-- table -->
            <table>
                <thead>
                    <tr>
                        <td colspan="9" align="center" style="color:red;"><h3>Historial de Pagos de Facturas Nacionales</h3></td>
                    </tr>
                    <tr>
                        <th class="text-center">RUT</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="text-center">FACTURA</th>
                        <th class="text-center">FECHA PAGO</th>
                        <th class="text-center">FORMA PAGO</th>
                        <th class="text-center">DOC. PAGO</th>
                        <th class="text-center">CARGOS</th>
                        <th class="text-center">ABONOS</th>
                        <th class="text-center">SALDOS</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($pagos as $factura)
                <tr>
                    <td class="text-center">{{$factura->cliente_rut}}</td>
                    <td class="text-center">{{$factura->cliente}}</td>
                    <td class="text-center">{{$factura->numero}}</td>
                    <td class="text-center">{{Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y')}}</td>
                    <td class="text-center">---</td>
                    <td class="text-center">Factura</td>
                    <td class="text-center">{{$factura->total}}</td>
                    <td class="text-center">0</td>
                    @if (isset($factura->notasDebito[0]) || isset($factura->pagos[0]))
                        <td class="text-center">0</td>
                    @else
                        <td class="text-center">{{$factura->deuda}}</td>
                    @endif
                </tr>

                @foreach ($factura->notasDebito as $notaDebito)
                <tr>
                    <td class="text-center">{{$factura->cliente_rut}}</td>
                    <td class="text-center">{{$factura->cliente}}</td>
                    <td class="text-center">{{$factura->numero}}</td>
                    <td class="text-center">{{Carbon\Carbon::parse($notaDebito->fecha)->format('d/m/Y')}}</td>
                    <td class="text-center">---</td>
                    <td class="text-center">Nota Débito {{$notaDebito->numero}}</td>
                    <td class="text-center">{{$notaDebito->total}}</td>
                    <td class="text-center">0</td>
                    @if ($loop->last)
                    @if (isset($factura->pagos[0]))
                        <td class="text-center">0</td>
                    @else
                        @if (isset($factura->notasDebito[0]))
                            <td class="text-center">{{($factura->deuda + $notaDebito->deuda)}}</td>
                        @else
                            <td class="text-center">0</td>
                        @endif
                    @endif
                        @else
                            <td class="text-center">0</td>
                    @endif
                </tr>


                @endforeach

                    @foreach ($factura->pagos as $pago)
                    <tr>
                        <td class="text-center">{{$factura->cliente_rut}}</td>
                        <td class="text-center">{{$factura->cliente}}</td>
                        <td class="text-center">{{$factura->numero}}</td>
                        <td class="text-center">{{Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y')}}</td>
                        <td class="text-center">
                            @if (empty($pago->formaPago_id))
                                N/D
                            @else
                                {{$pago->formaPago->descripcion}}
                            @endif
                            </td>

                        <td class="text-center">{{$pago->numero}}</td>
                        <td class="text-center">0</td>
                        <td class="text-center">{{$pago->monto}}</td>
                        @if ($loop->last)
                            @if (isset($pago->Factura->notasDebito[0]))
                                <td class="text-center">{{($factura->deuda + $pago->Factura->notasDebito->sum('deuda'))}}</td>
                            @else
                                <td class="text-center">{{$factura->deuda}}</td>
                            @endif
                        @else
                            <td class="text-center">0</td>
                        @endif
                    </tr>

                    @endforeach
                @endforeach
                <tr class="active">
                    <td colspan="9"></td>
                </tr>
                <tr>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"><strong style="color:red;">TOTALES</strong></td>
                    <td class="text-center"><strong style="color:red;">{{$pagos->total_cargo}}</strong></td>
                    <td class="text-center"><strong style="color:red;">{{$pagos->total_abono}}</strong></td>
                    <td class="text-center"><strong style="color:red;">{{$pagos->total}}</strong></td>
                </tr>
                </tbody>
            </table>
			<!-- /table -->
		</div>
