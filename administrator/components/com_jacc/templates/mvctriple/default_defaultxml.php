<<?php echo '?'?>xml version="1.0" encoding="utf-8"##codeend##
<metadata>
	<layout title="##Name##">
		<help
			key = "##Name##_DESC"
		/>
		<message>
			<![CDATA[##Name##_DESC]]>
		</message>
	</layout>
	<state>
	<name>##Name## Layout</name>
		<description>##Name## Layout_DESC</description>	
		<url addpath="/administrator/components/com_##component##/elements">
			<param name="##primary##" type="##name##" default="0" label="Select ##Name##" description="A ##Name##" />
		</url>
		<params>
		</params>
	</state>
	
	<!-- Fields for Joomla > 1.5. -->
	<fields name="request">
		<fieldset name="request"
			addfieldpath="/administrator/components/com_##component##/models/fields"
		>
			<field name="##primary##"
				type="##component####name##"
				description="##Name##_SELECT_DESC"
				label="Select ##Name##"
				required="true"
			/>
		</fieldset>
	</fields>	
	<!-- Add fields to the parameters object for the layout. -->
	<fields name="params">
	</fields>
</metadata>