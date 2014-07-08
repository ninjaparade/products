<script type="text/template" data-grid="product" data-template="results">

	<% _.each(results, function(r) { %>

		<tr>
			<td><input content="id" name="entries[]" type="checkbox" value="<%= r.id %>"></td>
			<td><a href="{{ URL::toAdmin('products/products/<%= r.id %>/edit') }}"><%= r.id %></a></td>
			<td><%= r.name %></td>
			<td><%= r.sku %></td>
			<td><%= r.price %></td>
			<td><%= r.image %></td>
			<td><%= r.brand %></td>
			<td><%= r.stock %></td>
			<td><%= r.created_at %></td>
		</tr>

	<% }); %>

</script>
