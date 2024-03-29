<?php

class PermissionsTableSeeder extends DatabaseSeeder
{
	public function run()
	{
		$permissions = [

			['name' => 'debugbar.openhandler', 'description' => 'debugbar.openhandler'],
			['name' => 'admin', 'description' => 'admin'],
			['name' => 'admin.user', 'description' => 'admin.user'],
			['name' => 'admin.user.view', 'description' => 'admin.user.view'],
			['name' => 'admin.user.create', 'description' => 'admin.user.create'],
			['name' => 'admin.user.save', 'description' => 'admin.user.save'],
			['name' => 'admin.user.edit', 'description' => 'admin.user.edit'],
			['name' => 'admin.user.update', 'description' => 'admin.user.update'],
			['name' => 'admin.user.delete', 'description' => 'admin.user.delete'],
			['name' => 'admin.user.destroy', 'description' => 'admin.user.destroy'],
			['name' => 'admin.user.deleted', 'description' => 'admin.user.deleted'],
			['name' => 'admin.user.deleted.view', 'description' => 'admin.user.deleted.view'],
			['name' => 'admin.user.deleted.edit', 'description' => 'admin.user.deleted.edit'],
			['name' => 'admin.user.deleted.update', 'description' => 'admin.user.deleted.update'],
			['name' => 'admin.user.deleted.delete', 'description' => 'admin.user.deleted.delete'],
			['name' => 'admin.user.deleted.destroy', 'description' => 'admin.user.deleted.destroy'],
			['name' => 'admin.user.deleted.restore', 'description' => 'admin.user.deleted.restore'],
			['name' => 'admin.user.deleted.reactivate', 'description' => 'admin.user.deleted.reactivate'],
			['name' => 'admin.partner', 'description' => 'admin.partner'],
			['name' => 'admin.partner.view', 'description' => 'admin.partner.view'],
			['name' => 'admin.partner.create', 'description' => 'admin.partner.create'],
			['name' => 'admin.partner.save', 'description' => 'admin.partner.save'],
			['name' => 'admin.partner.edit', 'description' => 'admin.partner.edit'],
			['name' => 'admin.partner.update', 'description' => 'admin.partner.update'],
			['name' => 'admin.partner.delete', 'description' => 'admin.partner.delete'],
			['name' => 'admin.partner.destroy', 'description' => 'admin.partner.destroy'],
			['name' => 'admin.partner.deleted', 'description' => 'admin.partner.deleted'],
			['name' => 'admin.partner.deleted.view', 'description' => 'admin.partner.deleted.view'],
			['name' => 'admin.partner.deleted.edit', 'description' => 'admin.partner.deleted.edit'],
			['name' => 'admin.partner.deleted.update', 'description' => 'admin.partner.deleted.update'],
			['name' => 'admin.partner.deleted.delete', 'description' => 'admin.partner.deleted.delete'],
			['name' => 'admin.partner.deleted.destroy', 'description' => 'admin.partner.deleted.destroy'],
			['name' => 'admin.partner.deleted.restore', 'description' => 'admin.partner.deleted.restore'],
			['name' => 'admin.partner.deleted.reactivate', 'description' => 'admin.partner.deleted.reactivate'],
			['name' => 'admin.role', 'description' => 'admin.role'],
			['name' => 'admin.role.create', 'description' => 'admin.role.create'],
			['name' => 'admin.role.save', 'description' => 'admin.role.save'],
			['name' => 'admin.role.edit', 'description' => 'admin.role.edit'],
			['name' => 'admin.role.update', 'description' => 'admin.role.update'],
			['name' => 'admin.role.delete', 'description' => 'admin.role.delete'],
			['name' => 'admin.role.destroy', 'description' => 'admin.role.destroy'],
			['name' => 'admin.perm', 'description' => 'admin.perm'],
			['name' => 'admin.perm.create', 'description' => 'admin.perm.create'],
			['name' => 'admin.perm.save', 'description' => 'admin.perm.save'],
			['name' => 'admin.perm.edit', 'description' => 'admin.perm.edit'],
			['name' => 'admin.perm.update', 'description' => 'admin.perm.update'],
			['name' => 'admin.perm.delete', 'description' => 'admin.perm.delete'],
			['name' => 'admin.perm.destroy', 'description' => 'admin.perm.destroy'],
			['name' => 'admin.offer', 'description' => 'admin.offer'],
			['name' => 'admin.offer.create', 'description' => 'admin.offer.create'],
			['name' => 'admin.offer.save', 'description' => 'admin.offer.save'],
			['name' => 'admin.offer.edit', 'description' => 'admin.offer.edit'],
			['name' => 'admin.offer.update', 'description' => 'admin.offer.update'],
			['name' => 'admin.offer.clearfield', 'description' => 'admin.offer.clearfield'],
			['name' => 'admin.offer.sort', 'description' => 'admin.offer.sort'],
			['name' => 'admin.offer.save_sort', 'description' => 'admin.offer.save_sort'],
			['name' => 'admin.offer.sort_comment', 'description' => 'admin.offer.sort_comment'],
			['name' => 'admin.offer.save_sort_comment', 'description' => 'admin.offer.save_sort_comment'],
			['name' => 'admin.offer.newsletter', 'description' => 'admin.offer.newsletter'],
			['name' => 'admin.offer.generate_newsletter', 'description' => 'admin.offer.generate_newsletter'],
			['name' => 'admin.config', 'description' => 'admin.config'],
			['name' => 'admin.config.create', 'description' => 'admin.config.create'],
			['name' => 'admin.config.save', 'description' => 'admin.config.save'],
			['name' => 'admin.config.edit', 'description' => 'admin.config.edit'],
			['name' => 'admin.config.update', 'description' => 'admin.config.update'],
			['name' => 'admin.config.delete', 'description' => 'admin.config.delete'],
			['name' => 'admin.config.destroy', 'description' => 'admin.config.destroy'],
			['name' => 'admin.faq', 'description' => 'admin.faq'],
			['name' => 'admin.faq.create', 'description' => 'admin.faq.create'],
			['name' => 'admin.faq.save', 'description' => 'admin.faq.save'],
			['name' => 'admin.faq.edit', 'description' => 'admin.faq.edit'],
			['name' => 'admin.faq.update', 'description' => 'admin.faq.update'],
			['name' => 'admin.faq.delete', 'description' => 'admin.faq.delete'],
			['name' => 'admin.faq.destroy', 'description' => 'admin.faq.destroy'],
			['name' => 'admin.order', 'description' => 'admin.order'],
			['name' => 'admin.order.view', 'description' => 'admin.order.view'],
			['name' => 'admin.order.voucher_cancel', 'description' => 'admin.order.voucher_cancel'],
			['name' => 'admin.order.teste', 'description' => 'admin.order.teste'],
			['name' => 'admin.order.offers', 'description' => 'admin.order.offers'],
			['name' => 'admin.order.offers_export', 'description' => 'admin.order.offers_export'],
			['name' => 'admin.order.list_offers_export', 'description' => 'admin.order.list_offers_export'],
			['name' => 'admin.order.list_paym_export', 'description' => 'admin.order.list_paym_export'],
			['name' => 'admin.order.cancel', 'description' => 'admin.order.cancel'],
			['name' => 'admin.order.approve', 'description' => 'admin.order.approve'],
			['name' => 'admin.order.convert_value_2_credit', 'description' => 'admin.order.convert_value_2_credit'],
			['name' => 'admin.order.voucher', 'description' => 'admin.order.voucher'],
			['name' => 'admin.order.voucher_export', 'description' => 'admin.order.voucher_export'],
			['name' => 'admin.category', 'description' => 'admin.category'],
			['name' => 'admin.category.create', 'description' => 'admin.category.create'],
			['name' => 'admin.category.save', 'description' => 'admin.category.save'],
			['name' => 'admin.category.edit', 'description' => 'admin.category.edit'],
			['name' => 'admin.category.update', 'description' => 'admin.category.update'],
			['name' => 'admin.category.delete', 'description' => 'admin.category.delete'],
			['name' => 'admin.category.destroy', 'description' => 'admin.category.destroy'],
			['name' => 'admin.category.sort', 'description' => 'admin.category.sort'],
			['name' => 'admin.category.save_sort', 'description' => 'admin.category.save_sort'],
			['name' => 'admin.coupon', 'description' => 'admin.coupon'],
			['name' => 'admin.coupon.create', 'description' => 'admin.coupon.create'],
			['name' => 'admin.coupon.save', 'description' => 'admin.coupon.save'],
			['name' => 'admin.coupon.edit', 'description' => 'admin.coupon.edit'],
			['name' => 'admin.coupon.update', 'description' => 'admin.coupon.update'],
			['name' => 'admin.coupon.delete', 'description' => 'admin.coupon.delete'],
			['name' => 'admin.coupon.destroy', 'description' => 'admin.coupon.destroy'],
			['name' => 'admin.comment', 'description' => 'admin.comment'],
			['name' => 'admin.comment.update_approved', 'description' => 'admin.comment.update_approved'],
			['name' => 'admin.ngo', 'description' => 'admin.ngo'],
			['name' => 'admin.ngo.create', 'description' => 'admin.ngo.create'],
			['name' => 'admin.ngo.save', 'description' => 'admin.ngo.save'],
			['name' => 'admin.ngo.edit', 'description' => 'admin.ngo.edit'],
			['name' => 'admin.ngo.update', 'description' => 'admin.ngo.update'],
			['name' => 'admin.ngo.delete', 'description' => 'admin.ngo.delete'],
			['name' => 'admin.ngo.destroy', 'description' => 'admin.ngo.destroy'],
			['name' => 'admin.ngo.clearfield', 'description' => 'admin.ngo.clearfield'],
			['name' => 'admin.genre', 'description' => 'admin.genre'],
			['name' => 'admin.genre.create', 'description' => 'admin.genre.create'],
			['name' => 'admin.genre.save', 'description' => 'admin.genre.save'],
			['name' => 'admin.genre.edit', 'description' => 'admin.genre.edit'],
			['name' => 'admin.genre.update', 'description' => 'admin.genre.update'],
			['name' => 'admin.genre.delete', 'description' => 'admin.genre.delete'],
			['name' => 'admin.genre.destroy', 'description' => 'admin.genre.destroy'],
			['name' => 'admin.tellus', 'description' => 'admin.tellus'],
			['name' => 'admin.tellus.create', 'description' => 'admin.tellus.create'],
			['name' => 'admin.tellus.save', 'description' => 'admin.tellus.save'],
			['name' => 'admin.tellus.edit', 'description' => 'admin.tellus.edit'],
			['name' => 'admin.tellus.update', 'description' => 'admin.tellus.update'],
			['name' => 'admin.tellus.delete', 'description' => 'admin.tellus.delete'],
			['name' => 'admin.tellus.destroy', 'description' => 'admin.tellus.destroy'],
			['name' => 'admin.tellus.sort', 'description' => 'admin.tellus.sort'],
			['name' => 'admin.tellus.save_sort', 'description' => 'admin.tellus.save_sort'],
			['name' => 'admin.tellus.clearfield', 'description' => 'admin.tellus.clearfield'],
			['name' => 'admin.tellus.approve', 'description' => 'admin.tellus.approve'],
			['name' => 'admin.partner_testimony', 'description' => 'admin.partner_testimony'],
			['name' => 'admin.partner_testimony.create', 'description' => 'admin.partner_testimony.create'],
			['name' => 'admin.partner_testimony.save', 'description' => 'admin.partner_testimony.save'],
			['name' => 'admin.partner_testimony.edit', 'description' => 'admin.partner_testimony.edit'],
			['name' => 'admin.partner_testimony.update', 'description' => 'admin.partner_testimony.update'],
			['name' => 'admin.partner_testimony.delete', 'description' => 'admin.partner_testimony.delete'],
			['name' => 'admin.partner_testimony.destroy', 'description' => 'admin.partner_testimony.destroy'],
			['name' => 'admin.partner_testimony.sort', 'description' => 'admin.partner_testimony.sort'],
			['name' => 'admin.partner_testimony.save_sort', 'description' => 'admin.partner_testimony.save_sort'],
			['name' => 'admin.partner_testimony.clearfield', 'description' => 'admin.partner_testimony.clearfield'],
			['name' => 'admin.suggest', 'description' => 'admin.suggest'],
			['name' => 'admin.suggest.create', 'description' => 'admin.suggest.create'],
			['name' => 'admin.suggest.save', 'description' => 'admin.suggest.save'],
			['name' => 'admin.suggest.edit', 'description' => 'admin.suggest.edit'],
			['name' => 'admin.suggest.update', 'description' => 'admin.suggest.update'],
			['name' => 'admin.suggest.delete', 'description' => 'admin.suggest.delete'],
			['name' => 'admin.suggest.destroy', 'description' => 'admin.suggest.destroy'],
			['name' => 'admin.destiny', 'description' => 'admin.destiny'],
			['name' => 'admin.destiny.create', 'description' => 'admin.destiny.create'],
			['name' => 'admin.destiny.save', 'description' => 'admin.destiny.save'],
			['name' => 'admin.destiny.edit', 'description' => 'admin.destiny.edit'],
			['name' => 'admin.destiny.update', 'description' => 'admin.destiny.update'],
			['name' => 'admin.destiny.delete', 'description' => 'admin.destiny.delete'],
			['name' => 'admin.destiny.destroy', 'description' => 'admin.destiny.destroy'],
			['name' => 'admin.holiday', 'description' => 'admin.holiday'],
			['name' => 'admin.holiday.create', 'description' => 'admin.holiday.create'],
			['name' => 'admin.holiday.save', 'description' => 'admin.holiday.save'],
			['name' => 'admin.holiday.edit', 'description' => 'admin.holiday.edit'],
			['name' => 'admin.holiday.update', 'description' => 'admin.holiday.update'],
			['name' => 'admin.holiday.delete', 'description' => 'admin.holiday.delete'],
			['name' => 'admin.holiday.destroy', 'description' => 'admin.holiday.destroy'],
			['name' => 'admin.included', 'description' => 'admin.included'],
			['name' => 'admin.included.create', 'description' => 'admin.included.create'],
			['name' => 'admin.included.save', 'description' => 'admin.included.save'],
			['name' => 'admin.included.edit', 'description' => 'admin.included.edit'],
			['name' => 'admin.included.update', 'description' => 'admin.included.update'],
			['name' => 'admin.included.delete', 'description' => 'admin.included.delete'],
			['name' => 'admin.included.destroy', 'description' => 'admin.included.destroy'],
			['name' => 'admin.tag', 'description' => 'admin.tag'],
			['name' => 'admin.tag.create', 'description' => 'admin.tag.create'],
			['name' => 'admin.tag.save', 'description' => 'admin.tag.save'],
			['name' => 'admin.tag.edit', 'description' => 'admin.tag.edit'],
			['name' => 'admin.tag.update', 'description' => 'admin.tag.update'],
			['name' => 'admin.tag.delete', 'description' => 'admin.tag.delete'],
			['name' => 'admin.tag.destroy', 'description' => 'admin.tag.destroy'],
			['name' => 'admin.contract', 'description' => 'admin.contract'],
			['name' => 'admin.contract.view', 'description' => 'admin.contract.view'],
			['name' => 'admin.contract.print', 'description' => 'admin.contract.print'],
			['name' => 'admin.contract.create', 'description' => 'admin.contract.create'],
			['name' => 'admin.contract.save', 'description' => 'admin.contract.save'],
			['name' => 'admin.contract.send', 'description' => 'admin.contract.send'],
			['name' => 'admin.contract.edit', 'description' => 'admin.contract.edit'],
			['name' => 'admin.contract.update', 'description' => 'admin.contract.update'],
			['name' => 'admin.contract.delete', 'description' => 'admin.contract.delete'],
			['name' => 'admin.contract.destroy', 'description' => 'admin.contract.destroy'],
			['name' => 'admin.payment', 'description' => 'admin.payment'],
			['name' => 'admin.payment.update_status', 'description' => 'admin.payment.update_status'],
			['name' => 'admin.payment.voucher', 'description' => 'admin.payment.voucher'],
			['name' => 'admin.payment.voucher_export', 'description' => 'admin.payment.voucher_export'],
			['name' => 'admin.payment.period', 'description' => 'admin.payment.period'],
			['name' => 'admin.payment.create', 'description' => 'admin.payment.create'],
			['name' => 'admin.payment.save', 'description' => 'admin.payment.save'],
			['name' => 'admin.payment.edit', 'description' => 'admin.payment.edit'],
			['name' => 'admin.payment.update', 'description' => 'admin.payment.update'],
			['name' => 'admin.payment.delete', 'description' => 'admin.payment.delete'],
			['name' => 'admin.payment.destroy', 'description' => 'admin.payment.destroy'],
			['name' => 'admin.transaction', 'description' => 'admin.transaction'],
			['name' => 'admin.transaction.export', 'description' => 'admin.transaction.export'],
			['name' => 'admin.newsletter', 'description' => 'admin.newsletter'],
			['name' => 'admin.newsletter.export', 'description' => 'admin.newsletter.export'],
			['name' => 'painel', 'description' => 'painel'],
			['name' => 'painel.order.offers', 'description' => 'painel.order.offers'],
			['name' => 'painel.order.list_offers_export', 'description' => 'painel.order.list_offers_export'],
			['name' => 'painel.order.voucher', 'description' => 'painel.order.voucher'],
			['name' => 'painel.order.update_tracking_code', 'description' => 'painel.order.update_tracking_code'],
			['name' => 'painel.order.schedule', 'description' => 'painel.order.schedule'],
			['name' => 'painel.order.voucher_export', 'description' => 'painel.order.voucher_export'],
			['name' => 'painel.contract', 'description' => 'painel.contract'],
			['name' => 'painel.contract.view', 'description' => 'painel.contract.view'],
			['name' => 'painel.contract.print', 'description' => 'painel.contract.print'],
			['name' => 'painel.contract.get_sign', 'description' => 'painel.contract.get_sign'],
			['name' => 'painel.contract.post_sign', 'description' => 'painel.contract.post_sign'],
			['name' => 'painel.payment', 'description' => 'painel.payment'],
			['name' => 'painel.payment.voucher', 'description' => 'painel.payment.voucher'],
			['name' => 'painel.payment.voucher_export', 'description' => 'painel.payment.voucher_export'],
			['name' => 'painel.payment.export', 'description' => 'painel.payment.export'],

		];

		foreach ($permissions as $permission)
		{
			Permission::create($permission);
		}
	}
}
