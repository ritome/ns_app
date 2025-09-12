<?php

return [
    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、バリデータークラスで使用される既定のエラーメッセージです。
    | いくつかのルールには、サイズに関するものなど、複数のバージョンがあります。
    | これらのメッセージを自由に調整してください。
    |
    */

    'accepted'        => ':attributeを承認してください。',
    'accepted_if'     => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url'      => ':attributeは、有効なURLではありません。',
    'after'           => ':attributeは、:dateより後の日付にしてください。',
    'after_or_equal'  => ':attributeは、:date以降の日付にしてください。',
    'alpha'           => ':attributeは、アルファベットのみ使用できます。',
    'alpha_dash'      => ':attributeは、英数字・アンダースコア・ハイフンが使用できます。',
    'alpha_num'       => ':attributeは、英数字のみ使用できます。',
    'array'           => ':attributeは、配列にしてください。',
    'before'          => ':attributeは、:dateより前の日付にしてください。',
    'before_or_equal' => ':attributeは、:date以前の日付にしてください。',
    'between'         => [
        'array'   => ':attributeの要素は、:min〜:max個にしてください。',
        'file'    => ':attributeは、:min〜:max KBのファイルにしてください。',
        'numeric' => ':attributeは、:min〜:maxの間で指定してください。',
        'string'  => ':attributeは、:min〜:max文字の間で指定してください。',
    ],
    'boolean'         => ':attributeは、trueかfalseを指定してください。',
    'confirmed'       => ':attributeの確認が一致しません。',
    'current_password' => 'パスワードが正しくありません。',
    'date'            => ':attributeは、有効な日付ではありません。',
    'date_equals'     => ':attributeは、:dateと同じ日付にしてください。',
    'date_format'     => ':attributeは、:format形式と一致しません。',
    'decimal'         => ':attributeは、小数点以下 :decimal 桁で指定してください。',
    'declined'        => ':attributeを拒否してください。',
    'declined_if'     => ':otherが:valueの場合、:attributeを拒否してください。',
    'different'       => ':attributeと:otherは、異なる値にしてください。',
    'digits'          => ':attributeは、:digits桁の数値にしてください。',
    'digits_between'  => ':attributeは、:min〜:max桁の数値にしてください。',
    'dimensions'      => ':attributeの画像サイズが無効です。',
    'distinct'        => ':attributeに重複した値があります。',
    'doesnt_end_with' => ':attributeは、次の値で終わってはいけません: :values。',
    'doesnt_start_with' => ':attributeは、次の値で始まってはいけません: :values。',
    'email'           => ':attributeは、有効なメールアドレス形式で指定してください。',
    'ends_with'       => ':attributeは、次の値のいずれかで終わる必要があります: :values。',
    'enum'            => '選択された:attributeは無効です。',
    'exists'          => '選択された:attributeは、有効ではありません。',
    'file'            => ':attributeは、ファイルにしてください。',
    'filled'          => ':attributeは、値を指定してください。',
    'gt'              => [
        'array'   => ':attributeの要素は、:value個より多くなければいけません。',
        'file'    => ':attributeは、:value KBより大きいファイルにしてください。',
        'numeric' => ':attributeは、:valueより大きい値にしてください。',
        'string'  => ':attributeは、:value文字より多い文字列にしてください。',
    ],
    'gte'             => [
        'array'   => ':attributeの要素は、:value個以上でなければいけません。',
        'file'    => ':attributeは、:value KB以上のファイルにしてください。',
        'numeric' => ':attributeは、:value以上の値にしてください。',
        'string'  => ':attributeは、:value文字以上の文字列にしてください。',
    ],
    'image'           => ':attributeは、画像にしてください。',
    'in'              => '選択された:attributeは、有効ではありません。',
    'in_array'        => ':attributeが:otherに存在しません。',
    'integer'         => ':attributeは、整数にしてください。',
    'ip'              => ':attributeは、有効なIPアドレスにしてください。',
    'ipv4'            => ':attributeは、有効なIPv4アドレスにしてください。',
    'ipv6'            => ':attributeは、有効なIPv6アドレスにしてください。',
    'json'            => ':attributeは、有効なJSON文字列にしてください。',
    'lowercase'       => ':attributeは、小文字にしてください。',
    'lt'              => [
        'array'   => ':attributeの要素は、:value個より少なくなければいけません。',
        'file'    => ':attributeは、:value KBより小さいファイルにしてください。',
        'numeric' => ':attributeは、:valueより小さい値にしてください。',
        'string'  => ':attributeは、:value文字より少ない文字列にしてください。',
    ],
    'lte'             => [
        'array'   => ':attributeの要素は、:value個以下でなければいけません。',
        'file'    => ':attributeは、:value KB以下のファイルにしてください。',
        'numeric' => ':attributeは、:value以下の値にしてください。',
        'string'  => ':attributeは、:value文字以下の文字列にしてください。',
    ],
    'mac_address'     => ':attributeは、有効なMACアドレスにしてください。',
    'max'             => [
        'array'   => ':attributeの要素は、:max個以下にしてください。',
        'file'    => ':attributeは、:max KB以下のファイルにしてください。',
        'numeric' => ':attributeは、:max以下の値にしてください。',
        'string'  => ':attributeは、:max文字以下にしてください。',
    ],
    'max_digits'      => ':attributeは、:max桁以下の数値にしてください。',
    'mimes'           => ':attributeは、:valuesタイプのファイルにしてください。',
    'mimetypes'       => ':attributeは、:valuesタイプのファイルにしてください。',
    'min'             => [
        'array'   => ':attributeの要素は、:min個以上にしてください。',
        'file'    => ':attributeは、:min KB以上のファイルにしてください。',
        'numeric' => ':attributeは、:min以上の値にしてください。',
        'string'  => ':attributeは、:min文字以上にしてください。',
    ],
    'min_digits'      => ':attributeは、:min桁以上の数値にしてください。',
    'multiple_of'     => ':attributeは、:valueの倍数にしてください。',
    'not_in'          => '選択された:attributeは、有効ではありません。',
    'not_regex'       => ':attributeの形式が無効です。',
    'numeric'         => ':attributeは、数値にしてください。',
    'password'        => [
        'letters'       => ':attributeは、少なくとも1文字の英字を含める必要があります。',
        'mixed'         => ':attributeは、少なくとも1文字の大文字と1文字の小文字を含める必要があります。',
        'numbers'       => ':attributeは、少なくとも1文字の数字を含める必要があります。',
        'symbols'       => ':attributeは、少なくとも1文字の記号を含める必要があります。',
        'uncompromised' => '入力された:attributeは、データリークに含まれています。別の:attributeを選択してください。',
    ],
    'present'         => ':attributeが存在しません。',
    'prohibited'      => ':attributeは、入力禁止です。',
    'prohibited_if'   => ':otherが:valueの場合、:attributeは入力禁止です。',
    'prohibited_unless' => ':otherが:valuesでない限り、:attributeは入力禁止です。',
    'prohibits'       => ':attributeは、:otherの入力を禁止します。',
    'regex'           => ':attributeの形式が無効です。',
    'required'        => ':attributeは、必須です。',
    'required_array_keys' => ':attributeは、:valuesのキーを含む必要があります。',
    'required_if'     => ':otherが:valueの場合、:attributeは必須です。',
    'required_if_accepted' => ':otherが承認された場合、:attributeは必須です。',
    'required_unless' => ':otherが:valuesでない限り、:attributeは必須です。',
    'required_with'   => ':valuesが存在する場合、:attributeは必須です。',
    'required_with_all' => ':valuesが全て存在する場合、:attributeは必須です。',
    'required_without' => ':valuesが存在しない場合、:attributeは必須です。',
    'required_without_all' => ':valuesが全て存在しない場合、:attributeは必須です。',
    'same'            => ':attributeと:otherは、同じ値にしてください。',
    'size'            => [
        'array'   => ':attributeの要素は、:size個にしてください。',
        'file'    => ':attributeは、:size KBにしてください。',
        'numeric' => ':attributeは、:sizeにしてください。',
        'string'  => ':attributeは、:size文字にしてください。',
    ],
    'starts_with'     => ':attributeは、次の値のいずれかで始まる必要があります: :values。',
    'string'          => ':attributeは、文字列にしてください。',
    'timezone'        => ':attributeは、有効なタイムゾーンを指定してください。',
    'unique'          => ':attributeは、既に使用されています。',
    'uploaded'        => ':attributeのアップロードに失敗しました。',
    'uppercase'       => ':attributeは、大文字にしてください。',
    'url'             => ':attributeは、有効なURL形式にしてください。',
    'ulid'            => ':attributeは、有効なULIDにしてください。',
    'uuid'            => ':attributeは、有効なUUIDにしてください。',

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、属性プレースホルダーを「:attribute」の代わりに
    | 読みやすい値や意味のある値に置き換えるために使用されます。
    |
    */

    'attributes' => [
        'name'          => '名前（表示名）',
        'full_name'     => '氏名',
        'email'         => 'メールアドレス',
        'password'      => 'パスワード',
        'employee_id'   => '職員ID',
        'role'          => '役割',
        'hire_date'     => '入職日',
    ],
];

