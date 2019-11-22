<table>
    <tr>
        <th>ID</th>
        <th>姓名</th>
    </tr>
    <?php foreach ($list as $item): ?>
        <tr>
            <td><?php echo $item['id'] ?></td>
            <td><?php echo $item['name'] ?></td>
            <td>
                <a href="/User/Edit/<?php echo $item['id'] ?>">编辑</a>
                <a href="/User/Delete/<?php echo $item['id'] ?>">删除</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>