<style>
.box.box-gray {
  border: 1px solid #333;
  background: #f0f0f0;
}

.box.box-gray > .box-footer {
	background: #f0f0f0;
}

/* Estilo de Tabla Novasys*/
.table-bordered.table-custom {
  border: 1px solid #333;
}
.table-bordered.table-custom > thead > tr > td,
.table-bordered.table-custom > thead > tr > th {
	border: 1px solid #333
}
.table-bordered.table-custom > tbody > tr > th,
.table-bordered.table-custom > tfoot > tr > th,
.table-bordered.table-custom > tbody > tr > td,
.table-bordered.table-custom > tfoot > tr > td {
  border: 0.1px solid #dcdcdc;
}
table > tbody {
  background-color: white;
}
table > thead {
  background-color: #c8c8c8;
}
</style>

<h1>HELLO WORLD</h1>

<P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis repellendus laborum voluptatibus quisquam impedit aliquid, perspiciatis maiores, quas obcaecati quidem deserunt quod laboriosam suscipit asperiores iure nihil illo nobis aperiam.</P>

<table class="table table-hover table-bordered table-custom table-condensed display nowrap" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th class="text-center">codigo</th>
			<th class="text-center">descripcion</th>
			<th class="text-center">cantidad</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="text-center">TUR32</td>
			<td class="text-center">Turbo 32x20x25g</td>
			<td class="text-center">30</td>
		</tr>
		<tr>
			<td class="text-center">TUR32</td>
			<td class="text-center">Turbo 32x20x25g</td>
			<td class="text-center">30</td>
		</tr>
		<tr>
			<td>TUR32</td>
			<td>Turbo 32x20x25g</td>
			<td>30</td>
		</tr>
	</tbody>
</table>
