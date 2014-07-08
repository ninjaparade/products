<script type="text/template" data-grid="package" data-template="results">

	<% _.each(results, function(r) { %>

		<tr>
			<td><input content="id" name="entries[]" type="checkbox" value="<%= r.id %>"></td>
			<td><a href="{{ URL::toAdmin('products/packages/<%= r.id %>/edit') }}"><%= r.id %></a></td>
			<td><%= r.name %></td>
			<td><%= r.price %></td>
			<td><%= r.products %></td>
			<td><%= r.image %></td>
			<td><%= r.description %></td>
			<td><%= r.brand %></td>
			<td><%= r.created_at %></td>
		</tr>

	<% }); %>

</script>
