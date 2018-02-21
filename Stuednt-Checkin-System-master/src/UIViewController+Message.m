//
//  UIViewController+Message.m
//  QRtest
//
//  Created by 邵闻远 on 20/04/2017.
//  Copyright © 2017 shaowy. All rights reserved.
//
#import "UIViewController+Message.h"

@implementation UIViewController (Message)

- (void)showAlertWithTitle:(NSString *)title message:(NSString *)message handler:(void (^) (UIAlertAction *action))handler;
{
    UIAlertController *alert = [UIAlertController alertControllerWithTitle:title message:message preferredStyle:UIAlertControllerStyleAlert];
    
    UIAlertAction *action = [UIAlertAction actionWithTitle:@"submit" style:UIAlertActionStyleDefault handler:handler];
    
    [alert addAction:action];
    [self presentViewController:alert animated:YES completion:nil];
}

@end
